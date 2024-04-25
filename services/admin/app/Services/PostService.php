<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Exception;

class PostService
{
    /**
     * @throws GuzzleException
     */
    public function getPosts(): array
    {
        $client = new Client(['timeout' => 10]);
        try {
            $response = $client->request('GET', 'http://172.29.0.1:8069/api/post');
            $response = json_decode($response->getBody()->getContents(), true);
        } catch (Exception $exception) {
            $response = [];
        }

        return $response;
    }
}
