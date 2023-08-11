<?php

namespace Dehim\Pay\Tests\Plugin\Unipay\QrCode;

use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;
use Dehim\Pay\Pay;
use Dehim\Pay\Plugin\Unipay\QrCode\PosNormalPlugin;
use Dehim\Pay\Provider\Unipay;
use Dehim\Pay\Rocket;
use Dehim\Pay\Tests\TestCase;

class PosNormalPluginTest extends TestCase
{
    /**
     * @var \Dehim\Pay\Plugin\Unipay\QrCode\PosNormalPlugin
     */
    protected $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new PosNormalPlugin();
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
        self::assertEquals(new Uri(Unipay::URL[Pay::MODE_NORMAL].'gateway/api/backTransReq.do'), $radar->getUri());
        self::assertEquals('000000', $payload['bizType']);
        self::assertEquals('01', $payload['txnType']);
        self::assertEquals('06', $payload['txnSubType']);
        self::assertEquals('08', $payload['channelType']);
    }
}
