<?php declare(strict_types=1);

namespace App\Models;


/**
 * @OA\Schema
 */
class OperationResultModel
{
    /**
     * @OA\Property(enum={"success", "fail", "error"})
     *
     * @var string
     */
    public $status;

    /**
     * @OA\Property
     *
     * @var mixed
     */
    public $data;

    /**
     * @OA\Property
     *
     * @var string|null
     */
    public $message;

    /**
     * @param string $status
     * @param mixed $data
     * @param string $message
     */
    public function __construct($status, $data = null, string $message = null)
    {
        $this->status = $status;
        $this->data = $data;
        $this->message = $message;
    }

    public function getStatusCode()
    {
        return [
            OperationResultStatus::SUCCESS => 200,
            OperationResultStatus::ERROR => 500,
            OperationResultStatus::FAIL => 400
        ][$this->status];
    }

    public static function fail(string $message = null, $data = null): OperationResultModel
    {
        return new self(OperationResultStatus::FAIL, $data, $message);
    }

    public static function success($data = null, string $message = null): OperationResultModel
    {
        return new self(OperationResultStatus::SUCCESS, $data, $message);
    }

    public static function error($data = null): OperationResultModel
    {
        return new self(OperationResultStatus::ERROR, $data);
    }
}
