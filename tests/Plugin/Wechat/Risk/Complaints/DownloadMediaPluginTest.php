<?php

namespace Dehim\Pay\Tests\Plugin\Wechat\Risk\Complaints;

use GuzzleHttp\Psr7\Uri;
use Dehim\Pay\Exception\Exception;
use Dehim\Pay\Exception\InvalidParamsException;
use Dehim\Pay\Direction\OriginResponseDirection;
use Dehim\Pay\Plugin\Wechat\Risk\Complaints\DownloadMediaPlugin;
use Dehim\Pay\Rocket;
use Dehim\Pay\Tests\TestCase;
use Yansongda\Supports\Collection;

class DownloadMediaPluginTest extends TestCase
{
    /**
     * @var \Dehim\Pay\Plugin\Wechat\Risk\Complaints\DownloadMediaPlugin
     */
    protected $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new DownloadMediaPlugin();
    }

    public function testNormal()
    {
        $rocket = new Rocket();
        $rocket->setParams([])->setPayload(new Collection(['media_url' => 'https://yansongda.cn']));

        $result = $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });

        $radar = $result->getRadar();

        self::assertEquals(OriginResponseDirection::class, $result->getDirection());
        self::assertEquals('GET', $radar->getMethod());
        self::assertEquals(new Uri('https://yansongda.cn'), $radar->getUri());
    }

    public function testNormalNoDownloadUrl()
    {
        $rocket = new Rocket();
        $rocket->setParams([])->setPayload(new Collection());

        self::expectException(InvalidParamsException::class);
        self::expectExceptionCode(Exception::MISSING_NECESSARY_PARAMS);

        $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });
    }
}
