<?php

namespace Dehim\Pay\Tests\Plugin\Alipay\Trade;

use Dehim\Pay\Direction\ResponseDirection;
use Dehim\Pay\Plugin\Alipay\Trade\PayPlugin;
use Dehim\Pay\Rocket;
use Dehim\Pay\Tests\TestCase;

class PayPluginTest extends TestCase
{
    protected $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new PayPlugin();
    }

    public function testNormal()
    {
        $rocket = new Rocket();
        $rocket->setParams([]);

        $result = $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });

        self::assertNotEquals(ResponseDirection::class, $result->getDirection());
        self::assertStringContainsString('alipay.trade.pay', $result->getPayload()->toJson());
        self::assertStringContainsString('FACE_TO_FACE_PAYMENT', $result->getPayload()->toJson());
        self::assertStringContainsString('bar_code', $result->getPayload()->toJson());
    }
}
