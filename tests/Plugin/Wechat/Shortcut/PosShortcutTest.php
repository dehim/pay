<?php

declare(strict_types=1);

namespace Dehim\Pay\Tests\Plugin\Wechat\Shortcut;

use Dehim\Pay\Plugin\Wechat\Pay\Pos\PayPlugin;
use Dehim\Pay\Plugin\Wechat\Shortcut\PosShortcut;
use Dehim\Pay\Tests\TestCase;

class PosShortcutTest extends TestCase
{
    protected PosShortcut $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new PosShortcut();
    }

    public function testDefault()
    {
        self::assertEquals([
            PayPlugin::class,
        ], $this->plugin->getPlugins([]));
    }
}
