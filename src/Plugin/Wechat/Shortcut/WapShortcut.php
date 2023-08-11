<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Wechat\Shortcut;

use Dehim\Pay\Contract\ShortcutInterface;
use Dehim\Pay\Plugin\Wechat\Pay\H5\PrepayPlugin;

class WapShortcut implements ShortcutInterface
{
    public function getPlugins(array $params): array
    {
        return [
            PrepayPlugin::class,
        ];
    }
}
