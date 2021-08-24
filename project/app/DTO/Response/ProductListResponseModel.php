<?php declare(strict_types=1);

namespace App\DTO\Response;

use Carbon\Carbon;

/**
 * @OA\Schema
 */
class ProductListResponseModel
{
    /**
     * @OA\Property
     */
    public int $id;

    /**
     * @OA\Property
     */
    public string $name;

    /**
     * @OA\Property
     */
    public int $categoryId;

    /**
     * @OA\Property
     */
    public float $price;

    /**
     * @OA\Property
     */
    public ?string $description;

    /**
     * @OA\Property
     */
    public ?int $sale;

    /**
     * @OA\Property
     */
    public float $salePrice;

    /**
     * @OA\Property
     */
    public bool $isNew;

    /**
     * @OA\Property
     */
    public bool $isTopSelling;

    /**
     * @OA\Property
     */
    public Carbon $createdAt;

    /**
     * @OA\Property
     */
    public ?Carbon $updatedAt;
}
