<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Wechat\Shortcut;

use Dehim\Pay\Contract\ShortcutInterface;
use Dehim\Pay\Plugin\Wechat\Pay\Common\RefundPlugin;

class RefundShortcut implements ShortcutInterface
{
    public function getPlugins(array $params): array
    {
        return [
            RefundPlugin::class,
        ];
    }
}
