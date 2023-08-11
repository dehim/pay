<?php

namespace Dehim\Pay\Tests\Stubs\Plugin;

use Dehim\Pay\Plugin\Wechat\GeneralV2Plugin;
use Dehim\Pay\Rocket;

class WechatGeneralV2PluginStub extends GeneralV2Plugin
{
    protected function getUri(Rocket $rocket): string
    {
        return 'yansongda/pay';
    }
}
