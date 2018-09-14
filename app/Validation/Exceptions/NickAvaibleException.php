<?php

namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class NickAvaibleException extends ValidationException
{
    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Nick is already taken.',
        ],
    ];
}
