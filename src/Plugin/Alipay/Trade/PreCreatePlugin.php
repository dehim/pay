<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Alipay\Trade;

use Dehim\Pay\Exception\ContainerException;
use Dehim\Pay\Exception\ServiceNotFoundException;
use Dehim\Pay\Plugin\Alipay\GeneralPlugin;
use Dehim\Pay\Rocket;
use Dehim\Pay\Traits\SupportServiceProviderTrait;

/**
 * @see https://opendocs.alipay.com/open/02ekfg?scene=common
 */
class PreCreatePlugin extends GeneralPlugin
{
    use SupportServiceProviderTrait;

    /**
     * @throws ContainerException
     * @throws ServiceNotFoundException
     */
    protected function doSomethingBefore(Rocket $rocket): void
    {
        $this->loadAlipayServiceProvider($rocket);
    }

    protected function getMethod(): string
    {
        return 'alipay.trade.precreate';
    }
}
