<?php

namespace Dehim\Pay\Tests\Plugin\Alipay\Fund;

use Dehim\Pay\Direction\ResponseDirection;
use Dehim\Pay\Plugin\Alipay\Fund\AuthOrderFreezePlugin;
use Dehim\Pay\Rocket;
use Dehim\Pay\Tests\TestCase;

class AuthOrderFreezePluginTest extends TestCase
{
    protected $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new AuthOrderFreezePlugin();
    }

    public function testNormal()
    {
        $rocket = new Rocket();
        $rocket->setParams([]);

        $result = $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });

        self::assertNotEquals(ResponseDirection::class, $result->getDirection());
        self::assertStringContainsString('alipay.fund.auth.order.freeze', $result->getPayload()->toJson());
        self::assertStringContainsString('PRE_AUTH', $result->getPayload()->toJson());
    }
}
