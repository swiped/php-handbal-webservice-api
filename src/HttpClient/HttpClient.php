<?php
namespace Swiped\HandbalWebservice\HttpClient;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;

class HttpClient implements HttpClientInterface
{
    /** @var GuzzleClient $client */
    protected $client;

    /** @var string $code */
    protected $code;

    /**
     * The default options that are passed to the Guzzle Client
     *
     * @var array
     */
    protected $options = array(
        'timeout'   => 30,
    );

    /**
     * Construct a new HttpClient instance.
     * A Guzzle client can optionally be passed as argument,
     * but a new instance will be created by default.
     *
     * @param string $code
     * @param GuzzleClientInterface $client
     */
    public function __construct($code, GuzzleClientInterface $client = null)
    {
        $this->code = $code;
        $client = $client ?: new GuzzleClient($this->options);
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function post($params = [])
    {
        $response = $this->client->request('POST', 'https://www.handbal.nl/kcp/' . $this->getPath(), [
            'form_params' => $params,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    protected function getPath()
    {
        return $this->code . '/json/';
    }
}
