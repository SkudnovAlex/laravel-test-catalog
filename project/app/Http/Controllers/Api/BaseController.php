<?php declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\OperationResultStatus;
use App\Models\OperationResultModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    public $attributes;

    protected function successResponse($data = null, string $message = null)
    {
        return response()->json(new OperationResultModel(OperationResultStatus::SUCCESS, $data, $message));
    }

    protected function failResponse(string $message = null, $data = null, int $code = null)
    {
        return response()->json(
            new OperationResultModel(OperationResultStatus::FAIL, $data, $message),
            $code ?? config('system.responseErrorCode.failResponse')
        );
    }

    protected function errorResponse($data = null)
    {
        return response()->json(new OperationResultModel(OperationResultStatus::ERROR, $data), 500);
    }

    protected function notFoundResponse(string $message = '')
    {
        return response()->json(new OperationResultModel(OperationResultStatus::FAIL, null, $message), 404);
    }

    protected function validationResponse(
        $responseData,
        ?string $failMessage = null,
        bool $skipForm = false
    ): JsonResponse {
        if (!isset($responseData) || count($responseData) === 0) {
            return $this->successResponse();
        }

        if ($skipForm) {
            unset($responseData['_form']);
        }

        return $this->failResponse($failMessage, $responseData, config('system.responseErrorCode.notValidRequest'));
    }
}
