<?php

namespace App\Enum;


class Enum
{
    public static function trans($value)
    {
        $class = class_basename(static::class);// Permissions
        return trans("enum.$class.$value");
    }
}
