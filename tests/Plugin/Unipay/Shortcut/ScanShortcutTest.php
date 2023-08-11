<?php

declare(strict_types=1);

namespace Dehim\Pay\Tests\Plugin\Unipay\Shortcut;

use Dehim\Pay\Exception\Exception;
use Dehim\Pay\Exception\InvalidParamsException;
use Dehim\Pay\Plugin\Unipay\QrCode\ScanFeePlugin;
use Dehim\Pay\Plugin\Unipay\QrCode\ScanNormalPlugin;
use Dehim\Pay\Plugin\Unipay\QrCode\ScanPreAuthPlugin;
use Dehim\Pay\Plugin\Unipay\QrCode\ScanPreOrderPlugin;
use Dehim\Pay\Plugin\Unipay\Shortcut\ScanShortcut;
use Dehim\Pay\Tests\TestCase;

class ScanShortcutTest extends TestCase
{
    protected $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new ScanShortcut();
    }

    public function testDefault()
    {
        self::assertEquals([
            ScanNormalPlugin::class,
        ], $this->plugin->getPlugins([]));
    }

    public function testPreAuth()
    {
        self::assertEquals([
            ScanPreAuthPlugin::class,
        ], $this->plugin->getPlugins(['_action' => 'pre_auth']));
    }

    public function testPreOrder()
    {
        self::assertEquals([
            ScanPreOrderPlugin::class,
        ], $this->plugin->getPlugins(['_action' => 'pre_order']));
    }

    public function testFee()
    {
        self::assertEquals([
            ScanFeePlugin::class,
        ], $this->plugin->getPlugins(['_action' => 'fee']));
    }

    public function testFoo()
    {
        self::expectException(InvalidParamsException::class);
        self::expectExceptionCode(Exception::SHORTCUT_MULTI_ACTION_ERROR);
        self::expectExceptionMessage('Scan action [fooPlugins] not supported');

        $this->plugin->getPlugins(['_action' => 'foo']);
    }
}
