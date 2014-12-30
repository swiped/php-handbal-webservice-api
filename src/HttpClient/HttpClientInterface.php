<?php
namespace KNKV\Webservice\HttpClient;

interface HttpClientInterface
{
    /**
     *
     * @param  array $parameters
     * @return array
     */
    public function post($parameters = []);

}
