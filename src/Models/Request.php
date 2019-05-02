<?php


namespace App\Models;

use App\Models\Address as Address;

class Request implements \JsonSerializable
{
    public $address;
    public $items;
    public $currency;
    public $key;

    public function __construct(Address $address, array $items, ?string $currency = null)
    {
        $this->address = $address;
        $this->items = $items;
        $this->currency = $currency;
        $this->key = md5(serialize($this));
    }

    public function jsonSerialize()
    {
        return [
            'recipient' => $this->address,
            'items' => $this->items,
            'currency' => $this->currency
        ];
    }
}
