<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Alipay\Fund;

use Closure;
use Dehim\Pay\Contract\PluginInterface;
use Dehim\Pay\Logger;
use Dehim\Pay\Rocket;

/**
 * @see https://opendocs.alipay.com/open/02fkb9
 */
class AuthOrderFreezePlugin implements PluginInterface
{
    public function assembly(Rocket $rocket, Closure $next): Rocket
    {
        Logger::debug('[alipay][AuthOrderFreezePlugin] 插件开始装载', ['rocket' => $rocket]);

        $rocket->mergePayload([
            'method' => 'alipay.fund.auth.order.freeze',
            'biz_content' => array_merge(
                [
                    'product_code' => 'PRE_AUTH',
                ],
                $rocket->getParams()
            ),
        ]);

        Logger::info('[alipay][AuthOrderFreezePlugin] 插件装载完毕', ['rocket' => $rocket]);

        return $next($rocket);
    }
}
