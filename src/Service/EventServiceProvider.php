<?php

declare(strict_types=1);

namespace Dehim\Pay\Service;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Dehim\Pay\Contract\EventDispatcherInterface;
use Dehim\Pay\Contract\ServiceProviderInterface;
use Dehim\Pay\Exception\ContainerException;
use Dehim\Pay\Pay;

class EventServiceProvider implements ServiceProviderInterface
{
    /**
     * @throws ContainerException
     */
    public function register(mixed $data = null): void
    {
        if (class_exists(EventDispatcher::class)) {
            Pay::set(EventDispatcherInterface::class, new EventDispatcher());
        }
    }
}
