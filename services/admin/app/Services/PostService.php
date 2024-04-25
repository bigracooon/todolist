<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class PostService
{
    /**
     * @throws GuzzleException
     */
    public function getPosts(): array
    {
        $client = new Client();
        $response = $client->request('GET', 'http://172.28.0.1:8069/api/post');
        return json_decode($response->getBody()->getContents(), true);
    }
}
