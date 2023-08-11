<?php

declare(strict_types=1);

namespace Dehim\Pay\Exception;

use Throwable;

class InvalidParamsException extends Exception
{
    public function __construct(int $code = self::PARAMS_ERROR, string $message = 'Params Error', mixed $extra = null, Throwable $previous = null)
    {
        parent::__construct($message, $code, $extra, $previous);
    }
}
