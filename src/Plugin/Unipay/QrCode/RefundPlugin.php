<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Unipay\QrCode;

use Dehim\Pay\Plugin\Unipay\GeneralPlugin;
use Dehim\Pay\Rocket;

/**
 * @see https://open.unionpay.com/tjweb/acproduct/APIList?acpAPIId=799&apiservId=468&version=V2.2&bussType=0
 */
class RefundPlugin extends GeneralPlugin
{
    protected function getUri(Rocket $rocket): string
    {
        return 'gateway/api/backTransReq.do';
    }

    protected function doSomething(Rocket $rocket): void
    {
        $rocket->mergePayload([
            'bizType' => '000000',
            'txnType' => '04',
            'txnSubType' => '00',
            'channelType' => '08',
        ]);
    }
}
