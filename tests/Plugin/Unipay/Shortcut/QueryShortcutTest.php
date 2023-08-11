<?php

declare(strict_types=1);

namespace Dehim\Pay\Tests\Plugin\Unipay\Shortcut;

use Dehim\Pay\Exception\Exception;
use Dehim\Pay\Exception\InvalidParamsException;
use Dehim\Pay\Plugin\Unipay\OnlineGateway\QueryPlugin;
use Dehim\Pay\Plugin\Unipay\Shortcut\QueryShortcut;
use Dehim\Pay\Tests\TestCase;

class QueryShortcutTest extends TestCase
{
    protected $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new QueryShortcut();
    }

    public function testDefault()
    {
        self::assertEquals([
            QueryPlugin::class,
        ], $this->plugin->getPlugins([]));
    }

    public function testQrCode()
    {
        self::assertEquals([
            \Dehim\Pay\Plugin\Unipay\QrCode\QueryPlugin::class,
        ], $this->plugin->getPlugins(['_action' => 'qr_code']));
    }

    public function testFoo()
    {
        self::expectException(InvalidParamsException::class);
        self::expectExceptionCode(Exception::SHORTCUT_MULTI_ACTION_ERROR);
        self::expectExceptionMessage('Query action [fooPlugins] not supported');

        $this->plugin->getPlugins(['_action' => 'foo']);
    }
}
