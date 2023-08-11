<?php

namespace Dehim\Pay\Tests\Plugin\Wechat\Fund\Transfer;

use Dehim\Pay\Exception\Exception;
use Dehim\Pay\Exception\InvalidParamsException;
use Dehim\Pay\Plugin\Wechat\Fund\Transfer\QueryBatchIdPlugin;
use Dehim\Pay\Rocket;
use Dehim\Pay\Tests\TestCase;
use Yansongda\Supports\Collection;

class QueryBatchIdPluginTest extends TestCase
{
    /**
     * @var \Dehim\Pay\Plugin\Wechat\Fund\Transfer\QueryBatchIdPlugin
     */
    protected $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new QueryBatchIdPlugin();
    }

    public function testNormal()
    {
        $rocket = new Rocket();
        $rocket->setParams([])->setPayload(new Collection(['batch_id' => '123', 'need_query_detail' => false]));

        $result = $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });

        $radar = $result->getRadar();
        $url = $radar->getUri();

        self::assertEquals('/v3/transfer/batches/batch-id/123', $url->getPath());
        self::assertEquals('need_query_detail=0', $url->getQuery());
        self::assertEquals('GET', $radar->getMethod());
    }

    public function testNormalNoBatchId()
    {
        $rocket = new Rocket();
        $rocket->setParams([])->setPayload(new Collection(['need_query_detail' => false]));

        self::expectException(InvalidParamsException::class);
        self::expectExceptionCode(Exception::MISSING_NECESSARY_PARAMS);

        $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });
    }

    public function testNormalNoNeedQueryDetail()
    {
        $rocket = new Rocket();
        $rocket->setParams([])->setPayload(new Collection(['batch_id' => '123']));

        self::expectException(InvalidParamsException::class);
        self::expectExceptionCode(Exception::MISSING_NECESSARY_PARAMS);

        $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });
    }

    public function testPartner()
    {
        $rocket = new Rocket();
        $rocket->setParams(['_config' => 'service_provider'])->setPayload(new Collection(['batch_id' => '123', 'need_query_detail' => false]));

        $result = $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });

        $radar = $result->getRadar();
        $url = $radar->getUri();

        self::assertEquals('/v3/partner-transfer/batches/batch-id/123', $url->getPath());
        self::assertEquals('need_query_detail=0', $url->getQuery());
        self::assertEquals('GET', $radar->getMethod());
    }

    public function testPartnerNoBatchId()
    {
        $rocket = new Rocket();
        $rocket->setParams(['_config' => 'service_provider'])->setPayload(new Collection(['need_query_detail' => false]));

        self::expectException(InvalidParamsException::class);
        self::expectExceptionCode(Exception::MISSING_NECESSARY_PARAMS);

        $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });
    }

    public function testPartnerNoNeedQueryDetail()
    {
        $rocket = new Rocket();
        $rocket->setParams(['_config' => 'service_provider'])->setPayload(new Collection(['batch_id' => '123']));

        self::expectException(InvalidParamsException::class);
        self::expectExceptionCode(Exception::MISSING_NECESSARY_PARAMS);

        $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });
    }
}
