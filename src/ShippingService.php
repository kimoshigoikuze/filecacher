<?php

namespace App;

use App\Interfaces\CacheInterface;
use App\Models\Request;
use App\Models\Response;
use App\Models\Config;

class ShippingService
{
    private $cache;
    private $api;
    private $config;

    public function __construct(Api $api, CacheInterface $cache, Config $config)
    {
        $this->cache = $cache;
        $this->api = $api;
        $this->config = $config;
    }

    public function call(Request $request): Response
    {
        $response = $this->cache->get($request->key);

        if (!$response) {
            $response = $this->api->call($request);

            $this->cache->set($request->key, $response, $this->config->duration);
        }

        return new Response($response);
    }
}
