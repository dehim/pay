<?php

declare(strict_types=1);

namespace Dehim\Pay\Tests\Plugin\Unipay\Shortcut;

use Dehim\Pay\Exception\InvalidParamsException;
use Dehim\Pay\Plugin\Unipay\OnlineGateway\RefundPlugin;
use Dehim\Pay\Plugin\Unipay\Shortcut\RefundShortcut;
use Dehim\Pay\Tests\TestCase;

class RefundShortcutTest extends TestCase
{
    protected $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new RefundShortcut();
    }

    public function testDefault()
    {
        self::assertEquals([
            RefundPlugin::class,
        ], $this->plugin->getPlugins([]));
    }

    public function testQrCode()
    {
        self::assertEquals([
            \Dehim\Pay\Plugin\Unipay\QrCode\RefundPlugin::class,
        ], $this->plugin->getPlugins(['_action' => 'qr_code']));
    }

    public function testFoo()
    {
        $this->expectException(InvalidParamsException::class);
        $this->expectExceptionMessage('Refund action [fooPlugins] not supported');

        $this->plugin->getPlugins(['_action' => 'foo']);
    }
}
