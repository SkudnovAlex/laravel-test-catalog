<?php

namespace App\Http\Requests\Product;

/**
 * @OA\Schema
 */
class ProductCreateRequest
{
    /**
     * @OA\Property(example="notebook")
     *
     * @var string
     */
    public string $name;

    /**
     * @OA\Property(example=1)
     *
     * @var int
     */
    public int $categoryId;

    /**
     * @OA\Property(example=10.88)
     *
     * @var float
     */
    public float $price;

    /**
     * @OA\Property(example="description")
     *
     * @var string
     */
    public string $description;
}
