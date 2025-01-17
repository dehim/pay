<?php

namespace Dehim\Pay\Tests\Plugin\Wechat\Risk\Complaints;

use GuzzleHttp\Psr7\Uri;
use Dehim\Pay\Direction\OriginResponseDirection;
use Dehim\Pay\Pay;
use Dehim\Pay\Plugin\Wechat\Risk\Complaints\DeleteCallbackPlugin;
use Dehim\Pay\Provider\Wechat;
use Dehim\Pay\Rocket;
use Dehim\Pay\Tests\TestCase;
use Yansongda\Supports\Collection;

class DeleteCallbackPluginTest extends TestCase
{
    /**
     * @var \Dehim\Pay\Plugin\Wechat\Risk\Complaints\DeleteCallbackPlugin
     */
    protected $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new DeleteCallbackPlugin();
    }

    public function testNormal()
    {
        $rocket = new Rocket();
        $rocket->setParams([])->setPayload(new Collection(['complaint_id' => '123', 'foo' => 'bar']));

        $result = $this->plugin->assembly($rocket, function ($rocket) {return $rocket;});

        $radar = $result->getRadar();

        self::assertEquals(new Uri(Wechat::URL[Pay::MODE_NORMAL].'v3/merchant-service/complaint-notifications'), $radar->getUri());
        self::assertNull($rocket->getPayload());
        self::assertEquals('DELETE', $radar->getMethod());
        self::assertEquals(OriginResponseDirection::class, $rocket->getDirection());
    }
}
