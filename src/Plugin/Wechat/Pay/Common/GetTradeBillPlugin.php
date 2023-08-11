<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Wechat\Pay\Common;

use Dehim\Pay\Plugin\Wechat\GeneralPlugin;
use Dehim\Pay\Rocket;

class GetTradeBillPlugin extends GeneralPlugin
{
    protected function getUri(Rocket $rocket): string
    {
        return 'v3/bill/tradebill?'.http_build_query($rocket->getParams());
    }

    protected function getMethod(): string
    {
        return 'GET';
    }

    protected function doSomething(Rocket $rocket): void
    {
        $rocket->setPayload(null);
    }
}
