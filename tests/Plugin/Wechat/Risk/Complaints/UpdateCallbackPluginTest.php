<?php

namespace Dehim\Pay\Tests\Plugin\Wechat\Risk\Complaints;

use GuzzleHttp\Psr7\Uri;
use Dehim\Pay\Pay;
use Dehim\Pay\Plugin\Wechat\Risk\Complaints\UpdateCallbackPlugin;
use Dehim\Pay\Provider\Wechat;
use Dehim\Pay\Rocket;
use Dehim\Pay\Tests\TestCase;
use Yansongda\Supports\Collection;

class UpdateCallbackPluginTest extends TestCase
{
    /**
     * @var \Dehim\Pay\Plugin\Wechat\Risk\Complaints\UpdateCallbackPlugin
     */
    protected $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new UpdateCallbackPlugin();
    }

    public function testNormal()
    {
        $rocket = new Rocket();
        $rocket->setParams([])->setPayload(new Collection(['url' => 'bar']));

        $result = $this->plugin->assembly($rocket, function ($rocket) {return $rocket;});

        $radar = $result->getRadar();

        self::assertEquals(new Uri(Wechat::URL[Pay::MODE_NORMAL].'v3/merchant-service/complaint-notifications'), $radar->getUri());
        self::assertEquals(['url' => 'bar'], $rocket->getPayload()->toArray());
        self::assertEquals('PUT', $radar->getMethod());
    }
}
