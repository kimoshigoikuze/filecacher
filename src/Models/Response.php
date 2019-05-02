<?php


namespace App\Models;


class Response
{
    public $body;

    public function __construct(string $body)
    {
        $this->body = $body;
    }

    public function toArray () {
        return json_decode($this->body, true);
    }
}
