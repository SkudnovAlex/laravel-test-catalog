<?php declare(strict_types=1);

namespace App\DTO\Category;

class CategoryModel
{
    public string $name;
    public int $parent;
    public float $sort;
    public string $code;
}
