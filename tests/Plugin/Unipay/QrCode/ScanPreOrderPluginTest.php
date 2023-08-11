<?php

namespace Dehim\Pay\Tests\Plugin\Unipay\QrCode;

use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;
use Dehim\Pay\Pay;
use Dehim\Pay\Plugin\Unipay\QrCode\ScanPreOrderPlugin;
use Dehim\Pay\Provider\Unipay;
use Dehim\Pay\Rocket;
use Dehim\Pay\Tests\TestCase;

class ScanPreOrderPluginTest extends TestCase
{
    /**
     * @var \Dehim\Pay\Plugin\Unipay\QrCode\ScanPreOrderPlugin
     */
    protected $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new ScanPreOrderPlugin();
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
        self::assertEquals(new Uri(Unipay::URL[Pay::MODE_NORMAL].'gateway/api/order.do'), $radar->getUri());
        self::assertEquals('000000', $payload['bizType']);
        self::assertEquals('01', $payload['txnType']);
        self::assertEquals('01', $payload['txnSubType']);
        self::assertEquals('08', $payload['channelType']);
    }
}
