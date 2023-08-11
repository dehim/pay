<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Alipay\Fund;

use Dehim\Pay\Plugin\Alipay\GeneralPlugin;

/**
 * @see https://opendocs.alipay.com/open/02fkbc
 */
class AuthOrderUnfreezePlugin extends GeneralPlugin
{
    protected function getMethod(): string
    {
        return 'alipay.fund.auth.order.unfreeze';
    }
}
