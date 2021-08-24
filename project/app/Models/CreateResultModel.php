<?php declare(strict_types=1);

namespace App\Models;

/**
 * @OA\Schema
 */
class CreateResultModel
{
    /**
     * @OA\Property
     */
    public int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }
}
