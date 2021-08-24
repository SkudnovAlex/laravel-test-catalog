<?php declare(strict_types=1);

namespace App\DTO\Product;

class ProductModel
{
    public string $id;
    public string $name;
    public int $categoryId;
    public float $price;
    public string $description;
}
