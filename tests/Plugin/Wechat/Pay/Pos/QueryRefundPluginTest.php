<?php

namespace Dehim\Pay\Tests\Plugin\Wechat\Pay\Pos;

use GuzzleHttp\Psr7\Uri;
use Dehim\Pay\Pay;
use Dehim\Pay\Plugin\Wechat\Pay\Pos\QueryRefundPlugin;
use Dehim\Pay\Provider\Wechat;
use Dehim\Pay\Rocket;
use Yansongda\Supports\Collection;

class QueryRefundPluginTest extends \Dehim\Pay\Tests\TestCase
{
    protected QueryRefundPlugin $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new QueryRefundPlugin();
    }

    public function testNormal()
    {
        $rocket = new Rocket();
        $rocket->setParams([])->setPayload(new Collection(['out_trade_no' => '123']));

        $result = $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });

        $radar = $result->getRadar();

        self::assertEquals(new Uri(Wechat::URL[Pay::MODE_NORMAL].'pay/refundquery'), $radar->getUri());
    }
}