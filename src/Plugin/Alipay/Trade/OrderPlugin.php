<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Alipay\Trade;

use Dehim\Pay\Plugin\Alipay\GeneralPlugin;

class OrderPlugin extends GeneralPlugin
{
    protected function getMethod(): string
    {
        return 'alipay.trade.order.pay';
    }
}
