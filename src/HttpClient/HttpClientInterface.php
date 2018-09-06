<?php
namespace Swiped\HandbalWebservice\HttpClient;

interface HttpClientInterface
{
    /**
     *
     * @param  array $parameters
     * @return array
     */
    public function post($parameters = []);
}
