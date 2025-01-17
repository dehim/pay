<?php

namespace Dehim\Pay\Tests\Plugin\Alipay\User;

use Dehim\Pay\Contract\DirectionInterface;
use Dehim\Pay\Plugin\Alipay\User\AgreementExecutionPlanModifyPlugin;
use Dehim\Pay\Rocket;
use Dehim\Pay\Tests\TestCase;

class AgreementExecutionPlanModifyPluginTest extends TestCase
{
    protected AgreementExecutionPlanModifyPlugin $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new AgreementExecutionPlanModifyPlugin();
    }

    public function testNormal()
    {
        $rocket = new Rocket();
        $rocket->setParams([]);

        $result = $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });

        self::assertEquals(DirectionInterface::class, $result->getDirection());
        self::assertStringContainsString('alipay.user.agreement.executionplan.modify', $result->getPayload()->toJson());
    }
}
