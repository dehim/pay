<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Alipay\Fund;

use Dehim\Pay\Plugin\Alipay\GeneralPlugin;

class TransTobankTransferPlugin extends GeneralPlugin
{
    protected function getMethod(): string
    {
        return 'alipay.fund.trans.tobank.transfer';
    }
}
