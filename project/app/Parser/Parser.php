<?php

namespace App\Parser;

use GuzzleHttp\Client;

abstract class Parser
{
    abstract public function run(): string;

    public function sendRequest(string $url, $options = [], string $method = 'GET')
    {
        if (empty($options['headers']['User-Agent'])) {
            $options['headers']['User-Agent'] = 'Mozilla/5.0 (Windows NT 6.3; W…) Gecko/20100101 Firefox/57.0';
        }

        $client = new Client();
        $response = $client->request($method, $url, $options);

        return $response->getBody()->getContents();
    }
}
