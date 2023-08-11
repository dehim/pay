<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Unipay\Shortcut;

use Dehim\Pay\Contract\ShortcutInterface;
use Dehim\Pay\Exception\Exception;
use Dehim\Pay\Exception\InvalidParamsException;
use Dehim\Pay\Plugin\Unipay\QrCode\PosNormalPlugin;
use Dehim\Pay\Plugin\Unipay\QrCode\PosPreAuthPlugin;
use Yansongda\Supports\Str;

class PosShortcut implements ShortcutInterface
{
    /**
     * @throws InvalidParamsException
     */
    public function getPlugins(array $params): array
    {
        $typeMethod = Str::camel($params['_action'] ?? 'default').'Plugins';

        if (method_exists($this, $typeMethod)) {
            return $this->{$typeMethod}();
        }

        throw new InvalidParamsException(Exception::SHORTCUT_MULTI_ACTION_ERROR, "Pos action [{$typeMethod}] not supported");
    }

    protected function defaultPlugins(): array
    {
        return [
            PosNormalPlugin::class,
        ];
    }

    protected function preAuthPlugins(): array
    {
        return [
            PosPreAuthPlugin::class,
        ];
    }
}
