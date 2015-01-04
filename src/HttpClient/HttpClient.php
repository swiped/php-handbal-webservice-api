<?php
namespace KNKV\Webservice\HttpClient;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;

class HttpClient implements HttpClientInterface
{
    /** @var string $code */
    protected $code;

    /**
     * The default options that are passed to the Guzzle Client
     *
     * @var array
     */
    protected $options = array(
        'base_url' => 'http://www.knkv.nl/kcp/',
        'defaults' => [
            'auth'      => 'knvb',
            'timeout'   => 30,
            'headers'   => [
                'User-Agent' => 'php-knvb-dataservice-api',
            ],
        ],
    );

    /**
     * Construct a new HttpClient instance. Optional parameters can be supplied.
     * A Guzzle client can optionally be passed as argument, but a new instance
     * will be created by default.
     *
     * @param string $code
     * @param array $options
     * @param GuzzleClientInterface $client
     */
    public function __construct($code, $options = [], GuzzleClientInterface $client = null)
    {
        $this->code = $code;
        $this->options = array_merge($this->options, $options);
        $client = $client ?: new GuzzleClient($this->options);
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function post($params = [])
    {
        return $this->client->post($this->getPath(), [
            'body' => $params,
        ])->json();
    }

    protected function getPath()
    {
        return $this->code . '/json/';
    }
}
