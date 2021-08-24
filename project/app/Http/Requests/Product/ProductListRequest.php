<?php

namespace App\Http\Requests\Product;

/**
 * @OA\Schema
 */
class ProductListRequest
{
    /**
     * @OA\Property(example=1)
     *
     * @var int
     */
    public int $categoryId;

    /**
     * @OA\Property(example=1)
     *
     * @var int|null
     */
    public ?int $page = 1;

    /**
     * @OA\Property(example=5)
     *
     * @var int|null
     */
    public ?int $pageSize = 20;
}
