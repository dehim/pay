<?php

namespace Dehim\Pay\Tests\Plugin\Alipay\Trade;

use Dehim\Pay\Direction\ResponseDirection;
use Dehim\Pay\Plugin\Alipay\Trade\PagePayPlugin;
use Dehim\Pay\Rocket;
use Dehim\Pay\Tests\TestCase;

class PagePayPluginTest extends TestCase
{
    protected $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new PagePayPlugin();
    }

    public function testNormal()
    {
        $rocket = new Rocket();
        $rocket->setParams([]);

        $result = $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });

        self::assertEquals(ResponseDirection::class, $result->getDirection());
        self::assertStringContainsString('alipay.trade.page.pay', $result->getPayload()->toJson());
        self::assertStringContainsString('FAST_INSTANT_TRADE_PAY', $result->getPayload()->toJson());
    }
}
