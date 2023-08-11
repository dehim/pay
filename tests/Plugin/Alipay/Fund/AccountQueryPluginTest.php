<?php

namespace Dehim\Pay\Tests\Plugin\Alipay\Fund;

use Dehim\Pay\Direction\ResponseDirection;
use Dehim\Pay\Plugin\Alipay\Fund\AccountQueryPlugin;
use Dehim\Pay\Rocket;
use Dehim\Pay\Tests\TestCase;

class AccountQueryPluginTest extends TestCase
{
    protected $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new AccountQueryPlugin();
    }

    public function testNormal()
    {
        $rocket = new Rocket();
        $rocket->setParams([]);

        $result = $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });

        self::assertNotEquals(ResponseDirection::class, $result->getDirection());
        self::assertStringContainsString('alipay.fund.account.query', $result->getPayload()->toJson());
        self::assertStringContainsString('TRANS_ACCOUNT_NO_PWD', $result->getPayload()->toJson());
    }
}
