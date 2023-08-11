<?php

namespace Dehim\Pay\Tests\Plugin\Wechat;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use Dehim\Pay\Exception\Exception;
use Dehim\Pay\Exception\InvalidResponseException;
use Dehim\Pay\Direction\NoHttpRequestDirection;
use Dehim\Pay\Direction\OriginResponseDirection;
use Dehim\Pay\Plugin\Wechat\LaunchPlugin;
use Dehim\Pay\Rocket;
use Dehim\Pay\Tests\TestCase;
use Yansongda\Supports\Collection;

class LaunchPluginTest extends TestCase
{
    /**
     * @var \Dehim\Pay\Plugin\Wechat\LaunchPlugin
     */
    protected $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new LaunchPlugin();
    }

    public function testShouldNotDoRequest()
    {
        $rocket = new Rocket();
        $rocket->setDirection(NoHttpRequestDirection::class);

        $result = $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });

        self::assertSame($rocket, $result);
    }

    public function testOriginalResponseDestination()
    {
        $destination = new Response();

        $rocket = new Rocket();
        $rocket->setDirection(OriginResponseDirection::class);
        $rocket->setDestination($destination);
        $rocket->setDestinationOrigin(new ServerRequest('POST', 'http://localhost'));

        $result = $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });

        self::assertSame($destination, $result->getDestination());
    }

    public function testOriginalResponseCodeErrorDestination()
    {
        $destination = new Response(500);

        $rocket = new Rocket();
        $rocket->setDirection(OriginResponseDirection::class);
        $rocket->setDestination($destination);
        $rocket->setDestinationOrigin(new ServerRequest('POST', 'http://localhost'));

        self::expectException(InvalidResponseException::class);
        self::expectExceptionCode(Exception::INVALID_RESPONSE_CODE);

        $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });
    }

    public function testArrayDestination()
    {
        $destination = [];

        $rocket = new Rocket();
        $rocket->setDirection(OriginResponseDirection::class);
        $rocket->setDestination(Collection::wrap($destination));
        $rocket->setDestinationOrigin(new ServerRequest('POST', 'http://localhost'));

        $result = $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });

        self::assertEquals($destination, $result->getDestination()->toArray());
    }

    public function testCollectionDestination()
    {
        $destination = new Collection();

        $rocket = new Rocket();
        $rocket->setDirection(OriginResponseDirection::class);
        $rocket->setDestination($destination);
        $rocket->setDestinationOrigin(new ServerRequest('POST', 'http://localhost'));

        $result = $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });

        self::assertSame($destination, $result->getDestination());
    }
}
