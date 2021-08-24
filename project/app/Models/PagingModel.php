<?php declare(strict_types=1);

namespace App\Models;

/**
 * @OA\Schema
 */
class PagingModel
{
    /**
     * @OA\Property(example=1)
     *
     * @var int
     */
    public int $total;

    /**
     * @OA\Property
     *
     * @var object[]
     */
    public array $data;

    public function __construct(int $total, array $data)
    {
        $this->total = $total;
        $this->data = $data;
    }
}
