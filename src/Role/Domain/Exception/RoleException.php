<?php

namespace App\Role\Domain\Exception;

use Exception;
use Throwable;

class RoleException extends Exception
{
    public const DEFAULT_ERROR_CODE = 400;
    public const DEFAULT_MESSAGE = "Invalid role.";

    public function __construct(string $message = self::DEFAULT_MESSAGE, ?int $code = self::DEFAULT_ERROR_CODE, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
