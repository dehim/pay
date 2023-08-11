<?php

declare(strict_types=1);

namespace Dehim\Pay\Contract;

use Dehim\Pay\Exception\ContainerException;

interface ServiceProviderInterface
{
    /**
     * @throws ContainerException
     */
    public function register(mixed $data = null): void;
}
