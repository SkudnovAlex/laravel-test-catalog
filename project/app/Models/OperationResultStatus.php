<?php declare(strict_types=1);

namespace App\Models;

use MyCLabs\Enum\Enum;

class OperationResultStatus extends Enum
{
    public const SUCCESS = 'success';
    public const FAIL = 'fail';
    public const ERROR = 'error';
}
