<?php

namespace Dehim\Pay\Tests\Plugin\Wechat\Fund\Profitsharing;

use GuzzleHttp\Psr7\Uri;
use Dehim\Pay\Pay;
use Dehim\Pay\Plugin\Wechat\Fund\Profitsharing\QueryMerchantConfigsPlugin;
use Dehim\Pay\Provider\Wechat;
use Dehim\Pay\Rocket;
use Dehim\Pay\Tests\TestCase;
use Yansongda\Supports\Collection;

class QueryMerchantConfigsPluginTest extends TestCase
{
    /**
     * @var \Dehim\Pay\Plugin\Wechat\Fund\Profitsharing\QueryMerchantConfigsPlugin
     */
    protected $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new QueryMerchantConfigsPlugin();
    }

    public function testPartner()
    {
        $rocket = new Rocket();
        $rocket->setParams(['_config' => 'service_provider'])->setPayload(new Collection());

        $result = $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });

        $radar = $result->getRadar();

        self::assertEquals(new Uri(Wechat::URL[Pay::MODE_SERVICE].'v3/profitsharing/merchant-configs/1600314070'), $radar->getUri());
        self::assertEquals('GET', $radar->getMethod());
    }

    public function testPartnerDirectPayload()
    {
        $rocket = new Rocket();
        $rocket->setParams(['_config' => 'service_provider'])->setPayload(new Collection(['sub_mchid' => '123']));

        $result = $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });

        $radar = $result->getRadar();

        self::assertEquals(new Uri(Wechat::URL[Pay::MODE_SERVICE].'v3/profitsharing/merchant-configs/123'), $radar->getUri());
    }
}
