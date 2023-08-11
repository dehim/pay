<?php

declare(strict_types=1);

namespace Dehim\Pay\Tests\Plugin\Unipay\Shortcut;

use Dehim\Pay\Plugin\Unipay\HtmlResponsePlugin;
use Dehim\Pay\Plugin\Unipay\OnlineGateway\PagePayPlugin;
use Dehim\Pay\Plugin\Unipay\Shortcut\WebShortcut;
use Dehim\Pay\Tests\TestCase;

class WebShortcutTest extends TestCase
{
    protected $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new WebShortcut();
    }

    public function test()
    {
        self::assertEquals([
            PagePayPlugin::class,
            HtmlResponsePlugin::class,
        ], $this->plugin->getPlugins([]));
    }
}
