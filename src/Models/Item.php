<?php

namespace App\Models;

class Item
{
    public $quantity;
    public $variant_id;
    public $external_variant_id;
    public $warehouse_product_variant_id;
    public $value;

    public function __construct(
        int $quantity,
        ?string $variant_id = null,
        ?string $external_variant_id = null,
        ?string $warehouse_product_variant_id = null,
        ?string $value = null
    )
    {
        $this->quantity = $quantity;
        $this->variant_id = $variant_id;
        $this->external_variant_id = $external_variant_id;
        $this->warehouse_product_variant_id = $warehouse_product_variant_id;
        $this->value = $value;

        try {
            if (
                $this->variant_id == null
                &&
                $this->external_variant_id == null
                &&
                $this->warehouse_product_variant_id == null
            ) {
                throw new \Exception('Item should have at least one id field.');
            }
        } catch (\Exception $exception) {
            echo 'Caught exception: ',  $exception->getMessage(), "\n";
        }
    }
}
