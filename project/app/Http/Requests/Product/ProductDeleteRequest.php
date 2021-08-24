<?php

namespace App\Http\Requests\Product;

/**
 * @OA\Schema
 */
class ProductDeleteRequest
{
    /**
     * @OA\Property(example=1)
     *
     * @var int
     */
    public int $id;
}
