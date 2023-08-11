<?php

namespace Dehim\Pay\Tests\Plugin\Wechat\Risk\Complaints;

use GuzzleHttp\Psr7\Uri;
use Dehim\Pay\Exception\Exception;
use Dehim\Pay\Exception\InvalidParamsException;
use Dehim\Pay\Direction\OriginResponseDirection;
use Dehim\Pay\Pay;
use Dehim\Pay\Plugin\Wechat\Risk\Complaints\CompleteComplaintPlugin;
use Dehim\Pay\Provider\Wechat;
use Dehim\Pay\Rocket;
use Dehim\Pay\Tests\TestCase;
use Yansongda\Supports\Collection;

class CompleteComplaintPluginTest extends TestCase
{
    /**
     * @var \Dehim\Pay\Plugin\Wechat\Risk\Complaints\CompleteComplaintPlugin
     */
    protected $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new CompleteComplaintPlugin();
    }

    public function testNormal()
    {
        $rocket = new Rocket();
        $rocket->setParams([])->setPayload(new Collection(['complaint_id' => '123', 'foo' => 'bar']));

        $result = $this->plugin->assembly($rocket, function ($rocket) {return $rocket;});

        $radar = $result->getRadar();

        self::assertEquals(new Uri(Wechat::URL[Pay::MODE_NORMAL].'v3/merchant-service/complaints-v2/123/complete'), $radar->getUri());
        self::assertEquals(['complainted_mchid' => '1600314069'], $rocket->getPayload()->toArray());
        self::assertEquals('POST', $radar->getMethod());
        self::assertEquals(OriginResponseDirection::class, $result->getDirection());
    }

    public function testDirectMchId()
    {
        $rocket = new Rocket();
        $rocket->setParams([])->setPayload(new Collection(['complaint_id' => '456', 'complainted_mchid' => 'bar']));

        $result = $this->plugin->assembly($rocket, function ($rocket) {return $rocket;});

        $radar = $result->getRadar();

        self::assertEquals(new Uri(Wechat::URL[Pay::MODE_NORMAL].'v3/merchant-service/complaints-v2/456/complete'), $radar->getUri());
        self::assertEquals(['complainted_mchid' => 'bar'], $rocket->getPayload()->toArray());
        self::assertEquals(OriginResponseDirection::class, $result->getDirection());
    }

    public function testMissingId()
    {
        $rocket = new Rocket();
        $rocket->setParams([])->setPayload(new Collection());

        self::expectException(InvalidParamsException::class);
        self::expectExceptionCode(Exception::MISSING_NECESSARY_PARAMS);

        $this->plugin->assembly($rocket, function ($rocket) {return $rocket;});
    }
}
