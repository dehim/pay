<?php

declare(strict_types=1);

namespace Dehim\Pay\Tests\Plugin\Wechat\Shortcut;

use Dehim\Pay\Exception\Exception;
use Dehim\Pay\Exception\InvalidParamsException;
use Dehim\Pay\Plugin\ParserPlugin;
use Dehim\Pay\Plugin\Wechat\Papay\ApplyPlugin;
use Dehim\Pay\Plugin\Wechat\Papay\ContractOrderPlugin;
use Dehim\Pay\Plugin\Wechat\Papay\OnlyContractPlugin;
use Dehim\Pay\Plugin\Wechat\Pay\Common\InvokePrepayV2Plugin;
use Dehim\Pay\Plugin\Wechat\PreparePlugin;
use Dehim\Pay\Plugin\Wechat\RadarSignPlugin;
use Dehim\Pay\Plugin\Wechat\Shortcut\PapayShortcut;
use Dehim\Pay\Tests\TestCase;

class PapayShortcutTest extends TestCase
{
    protected PapayShortcut $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new PapayShortcut();
    }

    public function testDefault()
    {
        self::assertEquals([
            PreparePlugin::class,
            ContractOrderPlugin::class,
            RadarSignPlugin::class,
            InvokePrepayV2Plugin::class,
            ParserPlugin::class,
        ], $this->plugin->getPlugins([]));
    }

    public function testDefaultMini()
    {
        self::assertEquals([
            PreparePlugin::class,
            ContractOrderPlugin::class,
            RadarSignPlugin::class,
            \Dehim\Pay\Plugin\Wechat\Pay\Mini\InvokePrepayV2Plugin::class,
            ParserPlugin::class,
        ], $this->plugin->getPlugins(['_type' => 'mini']));
    }

    public function testDefaultApp()
    {
        self::assertEquals([
            PreparePlugin::class,
            ContractOrderPlugin::class,
            RadarSignPlugin::class,
            \Dehim\Pay\Plugin\Wechat\Pay\App\InvokePrepayV2Plugin::class,
            ParserPlugin::class,
        ], $this->plugin->getPlugins(['_type' => 'app']));
    }

    public function testContract()
    {
        self::assertEquals([
            PreparePlugin::class,
            OnlyContractPlugin::class,
        ], $this->plugin->getPlugins(['_action' => 'contract']));
    }

    public function testApply()
    {
        self::assertEquals([
            PreparePlugin::class,
            ApplyPlugin::class,
            RadarSignPlugin::class,
            ParserPlugin::class,
        ], $this->plugin->getPlugins(['_action' => 'apply']));
    }

    public function testFoo()
    {
        self::expectException(InvalidParamsException::class);
        self::expectExceptionCode(Exception::SHORTCUT_MULTI_ACTION_ERROR);
        self::expectExceptionMessage('Papay action [fooPlugins] not supported');

        $this->plugin->getPlugins(['_action' => 'foo']);
    }
}
