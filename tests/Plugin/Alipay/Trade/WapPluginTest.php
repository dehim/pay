<?php

namespace Dehim\Pay\Tests\Plugin\Alipay\Trade;

use Dehim\Pay\Direction\ResponseDirection;
use Dehim\Pay\Plugin\Alipay\Trade\WapPayPlugin;
use Dehim\Pay\Rocket;
use Dehim\Pay\Tests\TestCase;

class WapPluginTest extends TestCase
{
    protected $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new WapPayPlugin();
    }

    public function testNormal()
    {
        $rocket = new Rocket();
        $rocket->setParams([]);

        $result = $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });

        self::assertEquals(ResponseDirection::class, $result->getDirection());
        self::assertStringContainsString('alipay.trade.wap.pay', $result->getPayload()->toJson());
        self::assertStringContainsString('QUICK_WAP_PAY', $result->getPayload()->toJson());
    }
}
