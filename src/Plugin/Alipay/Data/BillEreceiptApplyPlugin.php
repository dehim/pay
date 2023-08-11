<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Alipay\Data;

use Closure;
use Dehim\Pay\Contract\PluginInterface;
use Dehim\Pay\Logger;
use Dehim\Pay\Rocket;

/**
 * @see https://opendocs.alipay.com/open/029p6g
 */
class BillEreceiptApplyPlugin implements PluginInterface
{
    public function assembly(Rocket $rocket, Closure $next): Rocket
    {
        Logger::debug('[alipay][BillEreceiptApplyPlugin] 插件开始装载', ['rocket' => $rocket]);

        $rocket->mergePayload([
            'method' => 'alipay.data.bill.ereceipt.apply',
            'biz_content' => array_merge(
                [
                    'type' => 'FUND_DETAIL',
                ],
                $rocket->getParams(),
            ),
        ]);

        Logger::info('[alipay][BillEreceiptApplyPlugin] 插件装载完毕', ['rocket' => $rocket]);

        return $next($rocket);
    }
}
