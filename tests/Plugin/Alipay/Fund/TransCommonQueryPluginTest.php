<?php

namespace Dehim\Pay\Tests\Plugin\Alipay\Fund;

use Dehim\Pay\Direction\ResponseDirection;
use Dehim\Pay\Plugin\Alipay\Fund\TransCommonQueryPlugin;
use Dehim\Pay\Rocket;
use Dehim\Pay\Tests\TestCase;

class TransCommonQueryPluginTest extends TestCase
{
    protected $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new TransCommonQueryPlugin();
    }

    public function testNormal()
    {
        $rocket = new Rocket();
        $rocket->setParams([]);

        $result = $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });
        $payloadString = $result->getPayload()->toJson();

        self::assertNotEquals(ResponseDirection::class, $result->getDirection());
        self::assertStringContainsString('alipay.fund.trans.common.query', $payloadString);
        self::assertStringContainsString('TRANS_ACCOUNT_NO_PWD', $payloadString);
    }
}
