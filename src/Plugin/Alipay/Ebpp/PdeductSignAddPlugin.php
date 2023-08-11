<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Alipay\Ebpp;

use Closure;
use Dehim\Pay\Contract\PluginInterface;
use Dehim\Pay\Logger;
use Dehim\Pay\Rocket;

/**
 * @see https://opendocs.alipay.com/open/02hd33
 */
class PdeductSignAddPlugin implements PluginInterface
{
    public function assembly(Rocket $rocket, Closure $next): Rocket
    {
        Logger::debug('[alipay][PdeductSignAddPlugin] 插件开始装载', ['rocket' => $rocket]);

        $rocket->mergePayload([
            'method' => 'alipay.ebpp.pdeduct.sign.add',
            'biz_content' => array_merge(
                [
                    'charge_inst' => 'CQCENTERELECTRIC',
                    'agent_channel' => 'PUBLICPLATFORM',
                    'deduct_prod_code' => 'INST_DIRECT_DEDUCT',
                ],
                $rocket->getParams(),
            ),
        ]);

        Logger::info('[alipay][PdeductSignAddPlugin] 插件装载完毕', ['rocket' => $rocket]);

        return $next($rocket);
    }
}
