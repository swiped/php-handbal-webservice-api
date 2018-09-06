<?php
namespace Swiped\HandbalWebservice\HttpClient;

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
    public function __construct($code)
    {
        $this->code = $code;
    }

    /**
     * {@inheritdoc}
     */
    public function post($params = [])
    {
    
    	$url = 'https://www.handbal.nl/kcp/' . $this->getPath();

		//open connection
		$ch = curl_init();
		
		//loop through post fields
		$fields_string = '';
		foreach($params as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string, '&');

		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, count($params));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

		//set headers for processing the results
		if($params['file'] === 'xml') {
			header('Content-type: text/xml;charset=UTF-8');
		}
		if($params['file'] === 'json') {
			header('Content-type: application/json');
		}

		//execute post and gather results
		$result = curl_exec($ch);
		echo $result;
        return json_decode($result, true);
    }

    protected function getPath()
    {
        return $this->code . '/json/';
    }
}
