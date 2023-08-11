<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Wechat\Shortcut;

use Dehim\Pay\Contract\ShortcutInterface;
use Dehim\Pay\Exception\Exception;
use Dehim\Pay\Exception\InvalidParamsException;
use Dehim\Pay\Plugin\Wechat\Pay\Common\QueryPlugin;
use Dehim\Pay\Plugin\Wechat\Pay\Common\QueryRefundPlugin;
use Yansongda\Supports\Str;

class QueryShortcut implements ShortcutInterface
{
    /**
     * @throws InvalidParamsException
     */
    public function getPlugins(array $params): array
    {
        if (isset($params['combine_out_trade_no'])) {
            return $this->combinePlugins();
        }

        $typeMethod = Str::camel($params['_action'] ?? 'default').'Plugins';

        if (method_exists($this, $typeMethod)) {
            return $this->{$typeMethod}();
        }

        throw new InvalidParamsException(Exception::SHORTCUT_MULTI_ACTION_ERROR, "Query action [{$typeMethod}] not supported");
    }

    protected function defaultPlugins(): array
    {
        return [
            QueryPlugin::class,
        ];
    }

    protected function refundPlugins(): array
    {
        return [
            QueryRefundPlugin::class,
        ];
    }

    protected function combinePlugins(): array
    {
        return [
            \Dehim\Pay\Plugin\Wechat\Pay\Combine\QueryPlugin::class,
        ];
    }
}
