<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Alipay\Shortcut;

use Dehim\Pay\Contract\ShortcutInterface;
use Dehim\Pay\Plugin\Alipay\Trade\ClosePlugin;

class CloseShortcut implements ShortcutInterface
{
    public function getPlugins(array $params): array
    {
        return [
            ClosePlugin::class,
        ];
    }
}
