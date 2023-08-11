<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Alipay\Trade;

use Closure;
use Dehim\Pay\Contract\PluginInterface;
use Dehim\Pay\Direction\ResponseDirection;
use Dehim\Pay\Logger;
use Dehim\Pay\Rocket;

class PageRefundPlugin implements PluginInterface
{
    public function assembly(Rocket $rocket, Closure $next): Rocket
    {
        Logger::debug('[alipay][PageRefundPlugin] 插件开始装载', ['rocket' => $rocket]);

        $rocket->setDirection(ResponseDirection::class)
            ->mergePayload([
                'method' => 'alipay.trade.page.refund',
                'biz_content' => $rocket->getParams(),
            ]);

        Logger::info('[alipay][PageRefundPlugin] 插件装载完毕', ['rocket' => $rocket]);

        return $next($rocket);
    }
}
