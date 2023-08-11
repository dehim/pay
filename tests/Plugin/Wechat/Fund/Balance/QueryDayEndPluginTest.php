<?php

namespace Dehim\Pay\Tests\Plugin\Wechat\Fund\Balance;

use GuzzleHttp\Psr7\Uri;
use Dehim\Pay\Exception\Exception;
use Dehim\Pay\Exception\InvalidParamsException;
use Dehim\Pay\Pay;
use Dehim\Pay\Plugin\Wechat\Fund\Balance\QueryDayEndPlugin;
use Dehim\Pay\Provider\Wechat;
use Dehim\Pay\Rocket;
use Dehim\Pay\Tests\TestCase;
use Yansongda\Supports\Collection;

class QueryDayEndPluginTest extends TestCase
{
    /**
     * @var \Dehim\Pay\Plugin\Wechat\Fund\Balance\QueryDayEndPlugin
     */
    protected $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new QueryDayEndPlugin();
    }

    public function testNormal()
    {
        $rocket = new Rocket();
        $rocket->setParams([])->setPayload(new Collection(['account_type' => '123', 'date' => '2021-10-23']));

        $result = $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });

        $radar = $result->getRadar();

        self::assertEquals(new Uri(Wechat::URL[Pay::MODE_NORMAL].'v3/merchant/fund/dayendbalance/123?date=2021-10-23'), $radar->getUri());
        self::assertEquals('GET', $radar->getMethod());
    }

    public function testNormalNoAccountType()
    {
        $rocket = new Rocket();
        $rocket->setParams([])->setPayload(new Collection(['date' => '2021-10-23']));

        self::expectException(InvalidParamsException::class);
        self::expectExceptionCode(Exception::MISSING_NECESSARY_PARAMS);

        $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });
    }

    public function testNormalNoDate()
    {
        $rocket = new Rocket();
        $rocket->setParams([])->setPayload(new Collection(['account_type' => '123']));

        self::expectException(InvalidParamsException::class);
        self::expectExceptionCode(Exception::MISSING_NECESSARY_PARAMS);

        $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });
    }
}
