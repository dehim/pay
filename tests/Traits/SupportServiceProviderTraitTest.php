<?php

namespace Dehim\Pay\Tests\Traits;

use Dehim\Pay\Pay;
use Dehim\Pay\Rocket;
use Dehim\Pay\Tests\Stubs\Traits\SupportServiceProviderPluginStub;
use Dehim\Pay\Tests\TestCase;

class SupportServiceProviderTraitTest extends TestCase
{
    public function testNormal()
    {
        Pay::config([
           '_force' => true,
           'alipay' => [
               'default' => [
                   'mode' => Pay::MODE_SERVICE,
                   'service_provider_id' => 'yansongda'
               ]
           ]
        ]);

        $rocket = new Rocket();
        (new SupportServiceProviderPluginStub())->assembly($rocket);

        $result = json_encode($rocket->getParams());

        self::assertStringContainsString('extend_params', $result);
        self::assertStringContainsString('sys_service_provider_id', $result);
        self::assertStringContainsString('yansongda', $result);
    }
}
