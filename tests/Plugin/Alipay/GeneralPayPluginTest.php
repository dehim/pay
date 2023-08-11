<?php

namespace Dehim\Pay\Tests\Plugin\Alipay;

use Dehim\Pay\Rocket;
use Dehim\Pay\Tests\Stubs\Plugin\AlipayGeneralPluginStub;
use Dehim\Pay\Tests\TestCase;

class GeneralPayPluginTest extends TestCase
{
    public function testNormal()
    {
        $rocket = new Rocket();
        $rocket->setParams([]);

        $plugin = new AlipayGeneralPluginStub();

        $result = $plugin->assembly($rocket, function ($rocket) { return $rocket; });

        self::assertStringContainsString('yansongda', $result->getPayload()->toJson());
    }
}

