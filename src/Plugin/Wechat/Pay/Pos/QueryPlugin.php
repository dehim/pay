<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Wechat\Pay\Pos;

use Dehim\Pay\Plugin\Wechat\GeneralV2Plugin;
use Dehim\Pay\Rocket;

/**
 * @see https://pay.weixin.qq.com/wiki/doc/api/micropay.php?chapter=9_02
 */
class QueryPlugin extends GeneralV2Plugin
{
    protected function getUri(Rocket $rocket): string
    {
        return 'pay/orderquery';
    }
}
