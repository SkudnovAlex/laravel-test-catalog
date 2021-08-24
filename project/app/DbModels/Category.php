<?php

namespace App\DbModels;

use Database\Factories\ProductFactory;

class Category extends BaseModel
{
    protected $table = 'categories';

    protected $fillable = [
        'code'
    ];

    protected static function newFactory()
    {
        return ProductFactory::new();
    }
}
