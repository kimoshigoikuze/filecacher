<?php

require 'vendor/autoload.php';

use App\ShippingService;
use App\Api;
use App\FileCache;
use App\Models\Request;
use App\Models\Config;
use App\Models\Address;
use App\Models\Item;

CONST CACHE_DURATION = 5;
CONST CACHE_FILE_NAME = 'cache';

$address = new Address('11025 Westlake Dr', 'Charlotte, North Caroline','US', null, '28273');
$item = new Item(2, '7679');
$api = new Api('77qn9aax-qrrm-idki:lnh0-fm2nhmp0yca7');
$cache = new FileCache(CACHE_FILE_NAME);
$config = new Config(CACHE_DURATION);

$request = new Request($address, [$item], null);
$service = new ShippingService($api, $cache, $config);

$response = $service->call($request);

print_r($response->toArray());
