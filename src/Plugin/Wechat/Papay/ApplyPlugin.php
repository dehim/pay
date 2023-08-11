<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Wechat\Papay;

use Dehim\Pay\Plugin\Wechat\GeneralV2Plugin;
use Dehim\Pay\Rocket;

/**
 * 申请代扣.
 *
 * @see https://pay.weixin.qq.com/wiki/doc/api/wxpay_v2/papay/chapter3_8.shtml
 */
class ApplyPlugin extends GeneralV2Plugin
{
    protected function getUri(Rocket $rocket): string
    {
        return 'pay/pappayapply';
    }
}
