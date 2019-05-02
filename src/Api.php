<?php

namespace App;

use App\Models\Request;
use GuzzleHttp\Client;

class Api
{
    private $apiKey;
    private $network;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->network = new Client();
    }

    public function call(Request $request)
    {
       $response = $this->network->request(
            'POST',
            'https://api.printful.com/shipping/rates', [
            'headers' => [
                'authorization' => 'Basic ' . base64_encode($this->apiKey),
            ],
            'body' => json_encode($request),
        ]);

        return $response->getBody()->getContents();
    }
}
