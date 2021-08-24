<?php

namespace App\DbModels;

use Database\Factories\ProductFactory;

class Product extends BaseModel
{
    protected static function newFactory()
    {
        return ProductFactory::new();
    }
}
