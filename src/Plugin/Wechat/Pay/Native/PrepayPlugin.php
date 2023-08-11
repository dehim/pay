<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Wechat\Pay\Native;

use Dehim\Pay\Rocket;

/**
 * @see https://pay.weixin.qq.com/wiki/doc/apiv3/apis/chapter3_4_1.shtml
 */
class PrepayPlugin extends \Dehim\Pay\Plugin\Wechat\Pay\Common\PrepayPlugin
{
    protected function getUri(Rocket $rocket): string
    {
        return 'v3/pay/transactions/native';
    }

    protected function getPartnerUri(Rocket $rocket): string
    {
        return 'v3/pay/partner/transactions/native';
    }
}
