<?php

namespace Dehim\Pay\Tests\Stubs\Plugin;

use Dehim\Pay\Plugin\Alipay\GeneralPlugin;

class AlipayGeneralPluginStub extends GeneralPlugin
{
    protected function getMethod(): string
    {
        return 'yansongda';
    }
}
