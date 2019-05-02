<?php

namespace App\Models;

class Address
{
    public $address1;
    public $city;
    public $country_code;
    public $state_code;
    public $zip;

    public function __construct(string $address1, string $city, string $country_code, ?string $state_code = null, ?string $zip = null)
    {
        $this->address1 = $address1;
        $this->city = $city;
        $this->country_code = $country_code;
        $this->state_code = $state_code;
        $this->zip = $zip;
    }
}
