<?php

declare(strict_types=1);

namespace Dehim\Pay\Tests\Plugin\Unipay\Shortcut;

use Dehim\Pay\Plugin\Unipay\HtmlResponsePlugin;
use Dehim\Pay\Plugin\Unipay\OnlineGateway\WapPayPlugin;
use Dehim\Pay\Plugin\Unipay\Shortcut\WapShortcut;
use Dehim\Pay\Tests\TestCase;

class WapShortcutTest extends TestCase
{
    protected $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new WapShortcut();
    }

    public function test()
    {
        self::assertEquals([
            WapPayPlugin::class,
            HtmlResponsePlugin::class,
        ], $this->plugin->getPlugins([]));
    }
}
