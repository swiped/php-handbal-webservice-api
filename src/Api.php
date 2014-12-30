<?php
namespace KNKV\Webservice;

use GuzzleHttp\Exception\ParseException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Cache\ArrayStore;
use Illuminate\Cache\StoreInterface;
use JsonMapper;
use KNKV\Webservice\Exception\InvalidResponseException;
use KNKV\Webservice\HttpClient\HttpClient;
use KNKV\Webservice\HttpClient\HttpClientInterface;

class Api
{

	/** @var StoreInterface */
	protected $cache;

	/** @var HttpClientInterface $client  */
	protected $client;

	/** @var JsonMapper $mapper */
	protected $mapper;

	/** @var Club $club  */
	protected $club;

	/** @var string $code */
	protected $code;

	/** @var int Cache TTL */
	protected $cache_ttl = 60;

	protected $teams;

	/**
	 * @param string $code
	 * @param StoreInterface $cache
	 * @param HttpClientInterface $client
	 */
	public function __construct($code, StoreInterface $cache = null, HttpClientInterface $client = null)
	{
		$this->code = $code;
		$this->cache = $cache ?: new ArrayStore();
		$this->client = $client ?: new HttpClient($code);
		$this->mapper = new JsonMapper();
	}

	/**
	 * Make a request to the API
	 *
	 * @param string $type
	 * @param string|array $teamId
	 * @param boolean Full result
	 * @param int $page
	 * @throws InvalidResponseException
	 * @return array
	 */
	public function request($type, $teamId = '', $full = false, $page = 0)
	{
		$teamId = is_array($teamId) ? implode(',', $teamId) : $teamId;

		$parameters = array(
			'file' => 'json',
			'f' => 'get_data',
			't' => (string) $type,
			't_id' => (string) $teamId,
			'p' => (int) $page,
			'full' => $full ? 1 : 0,
		);

		$data = $this->getCached($parameters);
		if($data === null) {
			try {
				$data = $this->client->post($parameters) ?: [];
			}catch(ParseException $e){
				throw new InvalidResponseException("Cannot parse message: ".$e->getResponse()->getBody(), $e->getCode());
			}catch(RequestException $e) {
				throw new InvalidResponseException("Cannot finish request: " . $e->getMessage(). ', Request:' . $e->getRequest(), $e->getCode());
			}catch(\Exception $e){
				throw new InvalidResponseException($e->getMessage(), $e->getCode());
			}
			$this->setCached($parameters, $data);
		}

		return $data;
	}

	/**
	 * Get the result from the cache if possible
	 *
	 * @param array $params
	 * @return mixed
	 */
	protected function getCached(array $params)
	{
		$hash = $this->getCacheHash($params);
		return $this->cache->get($hash);
	}

	/**
	 * Store the result in the cache
	 *
	 * @param array $params
	 * @param mixed $result
	 */
	protected function setCached(array $params, $result)
	{
		$hash = $this->getCacheHash($params);
		$this->cache->put($hash, $result, $this->cache_ttl);
	}

	/**
	 * Sort the parameters and create an md5 hash.
	 *
	 * @param $params
	 * @return string
	 */
	protected function getCacheHash($params)
	{
		ksort($params);
		return md5(serialize($params));
	}

	/**
	 * Map data to an object
	 *
	 * @param array $json
	 * @param mixed $object
	 * @return mixed object
	 * @throws \JsonMapper_Exception
	 */
	public function map($json, $object)
	{
		return $this->mapper->map($json, $object);
	}


	/**
	 * @return Team[]
	 * @throws InvalidResponseException
	 */
	public function getTeams()
	{
		if ($this->teams) {
			return $this->teams;
		}

		$response = $this->request('teams');

		foreach($response as $category => $data) {
			foreach($data['v'] as $item) {
				$item['category'] = $category;

				/** @var Team $team */
				$team = $this->map($item, new Team($this));
				$this->teams[$team->team_id] = $team;

			}
		}

		return  $this->teams;
	}

	/**
	 * @param  string $id
	 * @throws MissingAttributeException
	 * @return Team
	 */
	public function getTeam($id)
	{
		$teams = $this->getTeams();

		if (isset($teams[$id])) {
			return $teams[$id];
		}

		throw new MissingAttributeException("Team $id is not available");
	}

	/**
	 * @param  boolean Full response
	 * @param  string Team ids
	 * @return Match[]
	 * @throws InvalidResponseException
	 */
	public function getProgram($full = false, $teamId = '')
	{
		$program = [];
		$response = $this->request('program', $teamId, $full);

		foreach($response as $week => $data) {
			foreach($data['items'] as $item) {
				/** @var Match $match */
				$match = $this->map($item, new Match);
				$program[] = $match;
			}
		}

		return $program;
	}

	/**
	 * @param  boolean Full response
	 * @param  int 	Page
	 * @param  string Team ids
	 * @return Match[]
	 * @throws InvalidResponseException
	 */
	public function getResults($full = false, $page = 0, $teamId = '')
	{
		$program = [];
		$response = $this->request('result', $teamId, $full, $page);

		foreach($response as $week => $data) {
			foreach($data['items'] as $item) {
				/** @var Match $match */
				$match = $this->map($item, new Match);
				$program[] = $match;
			}
		}

		return $program;
	}

	/**
	 * @param  string Team ids
	 * @return Match[]
	 * @throws InvalidResponseException
	 */
	public function getStandings($teamId = '')
	{
		$standings = [];
		$response = $this->request('standing', $teamId);

		foreach($response as $item) {
			/** @var Standing $standing */
			$standing = $this->map($item, new Standing);
			$standings[] = $standing;
		}

		return $standings;
	}
}
