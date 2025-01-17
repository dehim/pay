<?php

declare(strict_types=1);

namespace Dehim\Pay\Tests\Plugin\Wechat\Shortcut;

use Dehim\Pay\Exception\Exception;
use Dehim\Pay\Exception\InvalidParamsException;
use Dehim\Pay\Plugin\Alipay\Fund\TransCommonQueryPlugin;
use Dehim\Pay\Plugin\Wechat\Pay\Common\ClosePlugin;
use Dehim\Pay\Plugin\Wechat\Shortcut\CloseShortcut;
use Dehim\Pay\Tests\TestCase;

class CloseShortcutTest extends TestCase
{
    protected CloseShortcut $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new CloseShortcut();
    }

    public function testDefault()
    {
        self::assertEquals([
            ClosePlugin::class,
        ], $this->plugin->getPlugins([]));
    }

    public function testCombine()
    {
        self::assertEquals([
            \Dehim\Pay\Plugin\Wechat\Pay\Combine\ClosePlugin::class,
        ], $this->plugin->getPlugins(['_action' => 'combine']));
    }

    public function testCombineParams()
    {
        self::assertEquals([
            \Dehim\Pay\Plugin\Wechat\Pay\Combine\ClosePlugin::class,
        ], $this->plugin->getPlugins(['combine_out_trade_no' => '123abc']));

        self::assertEquals([
            \Dehim\Pay\Plugin\Wechat\Pay\Combine\ClosePlugin::class,
        ], $this->plugin->getPlugins(['sub_orders' => '123abc']));
    }

    public function testFoo()
    {
        self::expectException(InvalidParamsException::class);
        self::expectExceptionCode(Exception::SHORTCUT_MULTI_ACTION_ERROR);
        self::expectExceptionMessage('Query action [fooPlugins] not supported');

        $this->plugin->getPlugins(['_action' => 'foo']);
    }
}
