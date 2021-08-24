<?php

namespace App\Exceptions;

use App\Models\OperationResultModel;
use App\Models\OperationResultStatus;
use App\Services\Validation\FormValidationResponseStateBuilder;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException as FormRequestValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        FormRequestValidationException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $exception
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof FormRequestValidationException) {
            return $this->processFormRequestValidationException1($exception);
        }

        if ($exception instanceof HttpException) {
            return $this->processHttpException($exception);
        }

        return parent::render($request, $exception);
    }

    private function processFormRequestValidationException1(FormRequestValidationException $exception)
    {
        $messagesBag = $exception->validator->errors();
        $messageFields = $messagesBag->keys();

        $validationResponse = new FormValidationResponseStateBuilder();
        foreach ($messageFields as $messageField) {
            $messages = $messagesBag->get($messageField);
            if ($messageField === '_form') {
                continue;
            }

            $validationResponse = $validationResponse->field(Str::camel($messageField), $messages);
        }

        $validationResponse = $validationResponse->create($exception->validator->errors()->get('_form'));

        return response()->json(
            new OperationResultModel(
                \App\Models\OperationResultStatus::FAIL,
                $validationResponse
            ),
            config('system.responseErrorCode.notValidRequest')
        );
    }

    private function processHttpException(HttpException $exception)
    {
        $status = $exception->getStatusCode();

        if (in_array($status, [400, 401, 403, 404, 405, 406])) {
            $message = $exception->getMessage();
        } else {
            $message = (string)$exception;
            Log::error($message);
        }

        $message = isset($message) && $message !== ''
            ? $message
            : Response::$statusTexts[$status];

        return response()->json(
            new OperationResultModel(
                OperationResultStatus::FAIL,
                null,
                $message
            ),
            $status,
            $exception->getHeaders()
        );
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
