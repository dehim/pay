<?php

declare(strict_types=1);

namespace Dehim\Pay\Service;

use Dehim\Pay\Contract\ServiceProviderInterface;
use Dehim\Pay\Exception\ContainerException;
use Dehim\Pay\Pay;
use Dehim\Pay\Provider\Unipay;

class UnipayServiceProvider implements ServiceProviderInterface
{
    /**
     * @throws ContainerException
     */
    public function register(mixed $data = null): void
    {
        $service = new Unipay();

        Pay::set(Unipay::class, $service);
        Pay::set('unipay', $service);
    }
}
