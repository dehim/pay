<?php

namespace Dehim\Pay\Tests\Plugin\Unipay\OnlineGateway;

use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;
use Dehim\Pay\Direction\ResponseDirection;
use Dehim\Pay\Pay;
use Dehim\Pay\Plugin\Unipay\OnlineGateway\PagePayPlugin;
use Dehim\Pay\Provider\Unipay;
use Dehim\Pay\Rocket;
use Dehim\Pay\Tests\TestCase;

class PagePayPluginTest extends TestCase
{
    /**
     * @var \Dehim\Pay\Plugin\Unipay\OnlineGateway\PagePayPlugin
     */
    protected $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new PagePayPlugin();
    }

    public function testNormal()
    {
        $rocket = new Rocket();
        $rocket->setParams([]);

        $result = $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });

        $radar = $result->getRadar();
        $payload = $result->getPayload();

        self::assertInstanceOf(RequestInterface::class, $radar);
        self::assertEquals('POST', $radar->getMethod());
        self::assertEquals(new Uri(Unipay::URL[Pay::MODE_NORMAL].'gateway/api/frontTransReq.do'), $radar->getUri());
        self::assertEquals(ResponseDirection::class, $result->getDirection());
        self::assertEquals('000201', $payload['bizType']);
        self::assertEquals('01', $payload['txnType']);
        self::assertEquals('01', $payload['txnSubType']);
        self::assertEquals('07', $payload['channelType']);
    }
}
