<?php

namespace App\Models;

class Config
{
    public $duration;

    public function __construct(int $duration = 0)
    {
        $this->duration = $duration;
    }
}
