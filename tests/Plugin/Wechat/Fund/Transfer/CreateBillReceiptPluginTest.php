<?php

namespace Dehim\Pay\Tests\Plugin\Wechat\Fund\Transfer;

use GuzzleHttp\Psr7\Uri;
use Dehim\Pay\Exception\Exception;
use Dehim\Pay\Exception\InvalidParamsException;
use Dehim\Pay\Pay;
use Dehim\Pay\Plugin\Wechat\Fund\Transfer\CreateBillReceiptPlugin;
use Dehim\Pay\Provider\Wechat;
use Dehim\Pay\Rocket;
use Dehim\Pay\Tests\TestCase;
use Yansongda\Supports\Collection;

class CreateBillReceiptPluginTest extends TestCase
{
    /**
     * @var \Dehim\Pay\Plugin\Wechat\Fund\Transfer\CreateBillReceiptPlugin
     */
    protected $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new CreateBillReceiptPlugin();
    }

    public function testNormal()
    {
        $rocket = new Rocket();
        $rocket->setParams([])->setPayload(new Collection(['out_batch_no' => '123']));

        $result = $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });

        $radar = $result->getRadar();
        $payload = $result->getPayload();

        self::assertEquals(new Uri(Wechat::URL[Pay::MODE_NORMAL].'v3/transfer/bill-receipt'), $radar->getUri());
        self::assertEquals('123', $payload->get('out_batch_no'));
    }

    public function testNormalNoOutBatchNo()
    {
        $rocket = new Rocket();
        $rocket->setParams([])->setPayload(new Collection());

        self::expectException(InvalidParamsException::class);
        self::expectExceptionCode(Exception::MISSING_NECESSARY_PARAMS);

        $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });
    }

    public function testPartner()
    {
        $rocket = new Rocket();
        $rocket->setParams(['_config' => 'service_provider'])->setPayload(new Collection(['out_batch_no' => '123']));

        $result = $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });

        $radar = $result->getRadar();
        $payload = $result->getPayload();

        self::assertEquals(new Uri(Wechat::URL[Pay::MODE_NORMAL].'v3/transfer/bill-receipt'), $radar->getUri());
        self::assertEquals('123', $payload->get('out_batch_no'));
    }
}
