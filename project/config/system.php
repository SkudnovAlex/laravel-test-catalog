<?php

return [
    'responseErrorCode' => [
        'notValidRequest' => (int)env('RESPONSE_ERROR_CODE_NOT_VALID', 400),
        'failResponse' => (int)env('RESPONSE_ERROR_CODE_FAIL', 400),
    ],
];
