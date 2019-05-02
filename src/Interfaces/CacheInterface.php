<?php

namespace App\Interfaces;

interface CacheInterface
{
    public function set(string $key, $value, int $duration);
    public function get(string $key);
}
