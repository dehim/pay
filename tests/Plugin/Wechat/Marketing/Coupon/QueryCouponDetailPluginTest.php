<?php

namespace Dehim\Pay\Tests\Plugin\Wechat\Marketing\Coupon;

use GuzzleHttp\Psr7\Uri;
use Dehim\Pay\Exception\Exception;
use Dehim\Pay\Exception\InvalidParamsException;
use Dehim\Pay\Pay;
use Dehim\Pay\Plugin\Wechat\Marketing\Coupon\QueryCouponDetailPlugin;
use Dehim\Pay\Provider\Wechat;
use Dehim\Pay\Rocket;
use Dehim\Pay\Tests\TestCase;
use Yansongda\Supports\Collection;

class QueryCouponDetailPluginTest extends TestCase
{
    protected QueryCouponDetailPlugin $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new QueryCouponDetailPlugin();
    }

    public function testNormal()
    {
        $rocket = (new Rocket())->setParams([])->setPayload(new Collection([
            'coupon_id' => '123456',
            'openid' => '7890',
        ]));

        $result = $this->plugin->assembly($rocket, function ($rocket) {return $rocket; });

        $radar = $result->getRadar();

        self::assertEquals('GET', $radar->getMethod());
        self::assertNull($result->getPayload());
        self::assertEquals(new Uri(Wechat::URL[Pay::MODE_NORMAL].'v3/marketing/favor/users/7890/coupons/123456?appid=wx55955316af4ef13'), $radar->getUri());
    }

    public function testException()
    {
        self::expectException(InvalidParamsException::class);
        self::expectExceptionCode(Exception::MISSING_NECESSARY_PARAMS);

        $rocket = (new Rocket())->setParams([])->setPayload(new Collection([
            'coupon_id' => '123456',
            // 'openid' => '7890',
        ]));

        $this->plugin->assembly($rocket, function ($rocket) {return $rocket; });
    }

    public function testOtherAppId()
    {
        $rocket = (new Rocket())->setParams(['_type' => 'mini'])->setPayload(new Collection([
            'coupon_id' => '123456',
            'openid' => '7890',
        ]));

        $result = $this->plugin->assembly($rocket, function ($rocket) {return $rocket; });

        $radar = $result->getRadar();

        self::assertEquals('GET', $radar->getMethod());
        self::assertNull($result->getPayload());
        self::assertEquals(new Uri(Wechat::URL[Pay::MODE_NORMAL].'v3/marketing/favor/users/7890/coupons/123456?appid=wx55955316af4ef14'), $radar->getUri());
    }
}
