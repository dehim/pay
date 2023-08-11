<?php

namespace Dehim\Pay\Tests\Plugin;

use Dehim\Pay\Contract\DirectionInterface;
use Dehim\Pay\Contract\PackerInterface;
use Dehim\Pay\Direction\CollectionDirection;
use Dehim\Pay\Direction\NoHttpRequestDirection;
use Dehim\Pay\Exception\InvalidConfigException;
use Dehim\Pay\Packer\JsonPacker;
use Dehim\Pay\Pay;
use Dehim\Pay\Plugin\ParserPlugin;
use Dehim\Pay\Rocket;
use Dehim\Pay\Tests\Stubs\FooPackerStub;
use Dehim\Pay\Tests\Stubs\FooParserStub;
use Dehim\Pay\Tests\TestCase;

class ParserPluginTest extends TestCase
{
    protected ParserPlugin $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new ParserPlugin();

        Pay::set(DirectionInterface::class, CollectionDirection::class);
        Pay::set(PackerInterface::class, JsonPacker::class);
    }

    public function testWrongParser()
    {
        self::expectException(InvalidConfigException::class);
        self::expectExceptionCode(InvalidConfigException::INVALID_DIRECTION);

        $rocket = new Rocket();
        $rocket->setDirection(FooParserStub::class);

        $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });
    }

    public function testWrongPacker()
    {
        self::expectException(InvalidConfigException::class);
        self::expectExceptionCode(InvalidConfigException::INVALID_PACKER);

        $rocket = new Rocket();
        $rocket->setPacker(FooPackerStub::class);

        $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });
    }

    public function testDefaultParser()
    {
        Pay::set(DirectionInterface::class, NoHttpRequestDirection::class);

        $rocket = new Rocket();

        $result = $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });

        self::assertSame($rocket, $result);
    }

    public function testObjectParser()
    {
        Pay::set(DirectionInterface::class, new NoHttpRequestDirection());

        $rocket = new Rocket();

        $result = $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });

        self::assertSame($rocket, $result);
    }
}
