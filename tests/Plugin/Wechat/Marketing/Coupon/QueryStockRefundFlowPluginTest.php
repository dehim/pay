<?php

namespace Dehim\Pay\Tests\Plugin\Wechat\Marketing\Coupon;

use GuzzleHttp\Psr7\Uri;
use Dehim\Pay\Exception\Exception;
use Dehim\Pay\Exception\InvalidParamsException;
use Dehim\Pay\Pay;
use Dehim\Pay\Plugin\Wechat\Marketing\Coupon\QueryStockRefundFlowPlugin;
use Dehim\Pay\Provider\Wechat;
use Dehim\Pay\Rocket;
use Dehim\Pay\Tests\TestCase;
use Yansongda\Supports\Collection;

class QueryStockRefundFlowPluginTest extends TestCase
{
    protected QueryStockRefundFlowPlugin $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new QueryStockRefundFlowPlugin();
    }

    public function testNormal()
    {
        $rocket = (new Rocket())->setParams([])->setPayload(new Collection([
            'stock_id' => '123456',
        ]));

        $result = $this->plugin->assembly($rocket, function ($rocket) {return $rocket; });

        $radar = $result->getRadar();

        self::assertEquals('GET', $radar->getMethod());
        self::assertNull($result->getPayload());
        self::assertEquals(new Uri(Wechat::URL[Pay::MODE_NORMAL].'v3/marketing/favor/stocks/123456/refund-flow'), $radar->getUri());
    }

    public function testException()
    {
        self::expectException(InvalidParamsException::class);
        self::expectExceptionCode(Exception::MISSING_NECESSARY_PARAMS);

        $rocket = (new Rocket())->setParams([])->setPayload(new Collection());

        $this->plugin->assembly($rocket, function ($rocket) {return $rocket; });
    }
}
