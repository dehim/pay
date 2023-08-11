<?php

declare(strict_types=1);

namespace Dehim\Pay\Service;

use Dehim\Pay\Contract\ServiceProviderInterface;
use Dehim\Pay\Exception\ContainerException;
use Dehim\Pay\Pay;
use Dehim\Pay\Provider\Alipay;

class AlipayServiceProvider implements ServiceProviderInterface
{
    /**
     * @throws ContainerException
     */
    public function register(mixed $data = null): void
    {
        $service = new Alipay();

        Pay::set(Alipay::class, $service);
        Pay::set('alipay', $service);
    }
}
