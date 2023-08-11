<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Wechat\Risk\Complaints;

use Dehim\Pay\Plugin\Wechat\GeneralPlugin;
use Dehim\Pay\Rocket;

/**
 * @see https://pay.weixin.qq.com/wiki/doc/apiv3/apis/chapter10_2_11.shtml
 */
class QueryComplaintsPlugin extends GeneralPlugin
{
    protected function getMethod(): string
    {
        return 'GET';
    }

    protected function doSomething(Rocket $rocket): void
    {
        $rocket->setPayload(null);
    }

    protected function getUri(Rocket $rocket): string
    {
        return 'v3/merchant-service/complaints-v2?'.$rocket->getPayload()->query();
    }
}
