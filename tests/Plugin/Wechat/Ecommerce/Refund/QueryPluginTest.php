<?php

namespace Dehim\Pay\Tests\Plugin\Wechat\Ecommerce\Refund;

use GuzzleHttp\Psr7\Uri;
use Dehim\Pay\Exception\Exception;
use Dehim\Pay\Exception\InvalidParamsException;
use Dehim\Pay\Pay;
use Dehim\Pay\Plugin\Wechat\Ecommerce\Refund\QueryPlugin;
use Dehim\Pay\Provider\Wechat;
use Dehim\Pay\Rocket;
use Dehim\Pay\Tests\TestCase;
use Yansongda\Supports\Collection;

class QueryPluginTest extends TestCase
{
    /**
     * @var \Dehim\Pay\Plugin\Wechat\Ecommerce\Refund\QueryPlugin
     */
    protected $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new QueryPlugin();
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

    public function testPartnerRefundId()
    {
        $rocket = new Rocket();
        $rocket->setParams(['_config' => 'service_provider'])->setPayload(new Collection(['refund_id' => '123']));

        $result = $this->plugin->assembly($rocket, function ($rocket) {return $rocket; });

        $radar = $result->getRadar();

        self::assertEquals(new Uri(Wechat::URL[Pay::MODE_SERVICE].'v3/ecommerce/refunds/id/123?sub_mchid=1600314070'), $radar->getUri());
        self::assertEquals('GET', $radar->getMethod());
    }

    public function testPartnerOutRefundNo()
    {
        $rocket = new Rocket();
        $rocket->setParams(['_config' => 'service_provider'])->setPayload(new Collection(['out_refund_no' => '123']));

        $result = $this->plugin->assembly($rocket, function ($rocket) {return $rocket; });

        $radar = $result->getRadar();

        self::assertEquals(new Uri(Wechat::URL[Pay::MODE_SERVICE].'v3/ecommerce/refunds/out-refund-no/123?sub_mchid=1600314070'), $radar->getUri());
        self::assertEquals('GET', $radar->getMethod());
    }
}
