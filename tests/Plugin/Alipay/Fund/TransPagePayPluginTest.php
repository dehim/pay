<?php

namespace Dehim\Pay\Tests\Plugin\Alipay\Fund;

use Dehim\Pay\Direction\ResponseDirection;
use Dehim\Pay\Plugin\Alipay\Fund\TransPagePayPlugin;
use Dehim\Pay\Rocket;
use Dehim\Pay\Tests\TestCase;

class TransPagePayPluginTest extends TestCase
{
    protected $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new TransPagePayPlugin();
    }

    public function testNormal()
    {
        $rocket = new Rocket();
        $rocket->setParams([]);

        $result = $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });

        self::assertEquals(ResponseDirection::class, $result->getDirection());
        self::assertStringContainsString('alipay.fund.trans.page.pay', $result->getPayload()->toJson());
    }
}
