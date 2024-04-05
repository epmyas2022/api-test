<?php

namespace App\Enums;

use ReflectionClass;

enum SupportedLanguages: string
{
    case EN = 'en';
    case ES = 'es';

    public static function getAll(): array
    {
        $reflectionClass = new ReflectionClass(self::class);
        return $reflectionClass->getConstants();
    }


}
