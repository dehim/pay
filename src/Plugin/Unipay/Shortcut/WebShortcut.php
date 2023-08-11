<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Unipay\Shortcut;

use Dehim\Pay\Contract\ShortcutInterface;
use Dehim\Pay\Plugin\Unipay\HtmlResponsePlugin;
use Dehim\Pay\Plugin\Unipay\OnlineGateway\PagePayPlugin;

class WebShortcut implements ShortcutInterface
{
    public function getPlugins(array $params): array
    {
        return [
            PagePayPlugin::class,
            HtmlResponsePlugin::class,
        ];
    }
}
