<?php

declare(strict_types=1);

namespace Dehim\Pay\Service;

use Dehim\Pay\Contract\ServiceProviderInterface;
use Dehim\Pay\Exception\ContainerException;
use Dehim\Pay\Pay;
use Dehim\Pay\Provider\Wechat;

class WechatServiceProvider implements ServiceProviderInterface
{
    /**
     * @throws ContainerException
     */
    public function register(mixed $data = null): void
    {
        $service = new Wechat();

        Pay::set(Wechat::class, $service);
        Pay::set('wechat', $service);
    }
}
