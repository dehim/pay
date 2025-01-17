<?php

declare(strict_types=1);

namespace Dehim\Pay\Contract;

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Dehim\Pay\Exception\ContainerException;
use Dehim\Pay\Exception\InvalidParamsException;
use Dehim\Pay\Exception\ServiceNotFoundException;
use Yansongda\Supports\Collection;

interface ProviderInterface
{
    /**
     * @throws ContainerException
     * @throws InvalidParamsException
     * @throws ServiceNotFoundException
     */
    public function pay(array $plugins, array $params): Collection|MessageInterface|array|null;

    public function find(array|string $order): Collection|array;

    public function cancel(array|string $order): array|Collection|null;

    public function close(array|string $order): array|Collection|null;

    public function refund(array $order): Collection|array;

    public function callback(null|array|ServerRequestInterface $contents = null, ?array $params = null): Collection;

    public function success(): ResponseInterface;
}
