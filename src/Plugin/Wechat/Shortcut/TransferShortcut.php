<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Wechat\Shortcut;

use Dehim\Pay\Contract\ShortcutInterface;
use Dehim\Pay\Plugin\Wechat\Fund\Transfer\CreatePlugin;

class TransferShortcut implements ShortcutInterface
{
    public function getPlugins(array $params): array
    {
        return [
            CreatePlugin::class,
        ];
    }
}
