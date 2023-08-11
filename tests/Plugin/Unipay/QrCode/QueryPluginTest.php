<?php

namespace Dehim\Pay\Tests\Plugin\Unipay\QrCode;

use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;
use Dehim\Pay\Pay;
use Dehim\Pay\Plugin\Unipay\QrCode\QueryPlugin;
use Dehim\Pay\Provider\Unipay;
use Dehim\Pay\Rocket;
use Dehim\Pay\Tests\TestCase;

class QueryPluginTest extends TestCase
{
    /**
     * @var \Dehim\Pay\Plugin\Unipay\QrCode\QueryPlugin
     */
    protected $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new QueryPlugin();
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
        self::assertEquals(new Uri(Unipay::URL[Pay::MODE_NORMAL].'gateway/api/queryTrans.do'), $radar->getUri());
        self::assertEquals('000000', $payload['bizType']);
        self::assertEquals('00', $payload['txnType']);
        self::assertEquals('00', $payload['txnSubType']);
    }

    public function testSandbox()
    {
        $rocket = new Rocket();
        $rocket->setParams(['_config' => 'sandbox']);

        $result = $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });

        $radar = $result->getRadar();
        $payload = $result->getPayload();

        self::assertInstanceOf(RequestInterface::class, $radar);
        self::assertEquals('POST', $radar->getMethod());
        self::assertEquals(new Uri('https://101.231.204.80:5000/gateway/api/backTransReq.do'), $radar->getUri());
        self::assertEquals('000000', $payload['bizType']);
        self::assertEquals('00', $payload['txnType']);
        self::assertEquals('00', $payload['txnSubType']);
    }
}
