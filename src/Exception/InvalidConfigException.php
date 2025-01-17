<?php

declare(strict_types=1);

namespace Dehim\Pay\Exception;

use Throwable;

class InvalidConfigException extends Exception
{
    public function __construct(int $code = self::CONFIG_ERROR, string $message = 'Config Error', mixed $extra = null, Throwable $previous = null)
    {
        parent::__construct($message, $code, $extra, $previous);
    }
}
