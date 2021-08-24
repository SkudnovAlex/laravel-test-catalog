<?php declare(strict_types=1);

namespace App\Models;

class EmptyModel
{
    private static $value;

    public static function isEmpty($value): bool
    {
        return $value === self::getValue();
    }

    public static function getValue(): EmptyModel
    {
        if (!isset(self::$value)) {
            self::$value = new EmptyModel();
        }

        return self::$value;
    }
}
