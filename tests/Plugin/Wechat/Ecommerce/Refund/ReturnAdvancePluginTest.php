<?php

namespace Dehim\Pay\Tests\Plugin\Wechat\Ecommerce\Refund;

use GuzzleHttp\Psr7\Uri;
use Dehim\Pay\Exception\Exception;
use Dehim\Pay\Exception\InvalidParamsException;
use Dehim\Pay\Pay;
use Dehim\Pay\Plugin\Wechat\Ecommerce\Refund\ReturnAdvancePlugin;
use Dehim\Pay\Provider\Wechat;
use Dehim\Pay\Rocket;
use Dehim\Pay\Tests\TestCase;
use Yansongda\Supports\Collection;

class ReturnAdvancePluginTest extends TestCase
{
    /**
     * @var \Dehim\Pay\Plugin\Wechat\Ecommerce\Refund\ReturnAdvancePlugin
     */
    protected $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new ReturnAdvancePlugin();
    }

    public function testNotInServiceMode()
    {
        $rocket = new Rocket();
        $rocket->setParams([])->setPayload(new Collection());

        $this->expectException(InvalidParamsException::class);
        $this->expectExceptionCode(Exception::NOT_IN_SERVICE_MODE);

        $this->plugin->assembly($rocket, function ($rocket) {return $rocket; });
    }

    public function testMissingParams()
    {
        $rocket = new Rocket();
        $rocket->setParams(['_config' => 'service_provider'])->setPayload(new Collection());

        $this->expectException(InvalidParamsException::class);
        $this->expectExceptionCode(Exception::MISSING_NECESSARY_PARAMS);

        $this->plugin->assembly($rocket, function ($rocket) {return $rocket; });
    }

    public function testNormal()
    {
        $rocket = new Rocket();
        $rocket->setParams(['_config' => 'service_provider'])->setPayload(new Collection(['refund_id' => '123']));

        $result = $this->plugin->assembly($rocket, function ($rocket) {return $rocket; });

        $radar = $result->getRadar();
        $payload = $result->getPayload();

        self::assertEquals(new Uri(Wechat::URL[Pay::MODE_SERVICE].'v3/ecommerce/refunds/123/return-advance'), $radar->getUri());
        self::assertEquals('1600314070', $payload->get('sub_mchid'));
        self::assertArrayNotHasKey('refund_id', $payload->all());
    }
}
