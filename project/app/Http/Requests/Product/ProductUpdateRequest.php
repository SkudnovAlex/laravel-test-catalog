<?php

namespace App\Http\Requests\Product;

/**
 * @OA\Schema
 */
class ProductUpdateRequest
{
    /**
     * @OA\Property(example=1)
     *
     * @var int
     */
    public int $id;

    /**
     * @OA\Property(example="pen")
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
     * @OA\Property(example=25.56)
     *
     * @var float
     */
    public float $price;

    /**
     * @OA\Property(example="bla-bla-bla")
     *
     * @var string
     */
    public string $description;
}
