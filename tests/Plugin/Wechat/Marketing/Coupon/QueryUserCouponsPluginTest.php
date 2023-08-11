<?php

namespace Dehim\Pay\Tests\Plugin\Wechat\Marketing\Coupon;

use GuzzleHttp\Psr7\Uri;
use Dehim\Pay\Exception\Exception;
use Dehim\Pay\Exception\InvalidParamsException;
use Dehim\Pay\Pay;
use Dehim\Pay\Plugin\Wechat\Marketing\Coupon\QueryUserCouponsPlugin;
use Dehim\Pay\Provider\Wechat;
use Dehim\Pay\Rocket;
use Dehim\Pay\Tests\TestCase;
use Yansongda\Supports\Collection;

class QueryUserCouponsPluginTest extends TestCase
{
    protected QueryUserCouponsPlugin $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new QueryUserCouponsPlugin();
    }

    public function testNormal()
    {
        $rocket = (new Rocket())->setParams([])->setPayload(new Collection([
            'openid' => '123',
            'limit' => 1,
        ]));

        $result = $this->plugin->assembly($rocket, function ($rocket) {return $rocket; });

        $radar = $result->getRadar();

        self::assertEquals('GET', $radar->getMethod());
        self::assertNull($result->getPayload());
        self::assertEquals(new Uri(Wechat::URL[Pay::MODE_NORMAL].'v3/marketing/favor/users/123/coupons?limit=1&appid=wx55955316af4ef13&creator_mchid=1600314069'), $radar->getUri());
    }

    public function testException()
    {
        self::expectException(InvalidParamsException::class);
        self::expectExceptionCode(Exception::MISSING_NECESSARY_PARAMS);

        $rocket = (new Rocket())->setParams([])->setPayload(new Collection());

        $this->plugin->assembly($rocket, function ($rocket) {return $rocket; });
    }

    public function testOtherAppId()
    {
        $rocket = (new Rocket())->setParams(['_type' => 'mini'])->setPayload(new Collection([
            'openid' => '123',
            'limit' => 1,
        ]));

        $result = $this->plugin->assembly($rocket, function ($rocket) {return $rocket; });

        $radar = $result->getRadar();

        self::assertEquals(new Uri(Wechat::URL[Pay::MODE_NORMAL].'v3/marketing/favor/users/123/coupons?limit=1&appid=wx55955316af4ef14&creator_mchid=1600314069'), $radar->getUri());
    }
}
