<?php

namespace Dehim\Pay\Tests\Plugin\Alipay\User;

use Dehim\Pay\Contract\DirectionInterface;
use Dehim\Pay\Plugin\Alipay\User\InfoSharePlugin;
use Dehim\Pay\Rocket;
use Dehim\Pay\Tests\TestCase;

class InfoSharePluginTest extends TestCase
{
    protected $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new InfoSharePlugin();
    }

    public function testNormal()
    {
        $rocket = new Rocket();
        $rocket->setParams([]);

        $result = $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });

        self::assertEquals(DirectionInterface::class, $result->getDirection());
        self::assertStringContainsString('alipay.user.info.share', $result->getPayload()->toJson());
        self::assertStringContainsString('auth_token', $result->getPayload()->toJson());
    }
}
