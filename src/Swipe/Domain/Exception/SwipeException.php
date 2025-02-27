<?php

namespace App\Swipe\Domain\Exception;

use Exception;
use Throwable;

class SwipeException extends Exception
{
    public const DEFAULT_ERROR_CODE = 400;
    public const DEFAULT_MESSAGE = "Invalid swipe.";

    public function __construct(string $message = self::DEFAULT_MESSAGE, ?int $code = self::DEFAULT_ERROR_CODE, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
