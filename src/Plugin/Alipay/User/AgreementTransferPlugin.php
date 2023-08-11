<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Alipay\User;

use Closure;
use Dehim\Pay\Contract\PluginInterface;
use Dehim\Pay\Logger;
use Dehim\Pay\Rocket;

/**
 * @see https://opendocs.alipay.com/open/02fkar?ref=api
 */
class AgreementTransferPlugin implements PluginInterface
{
    public function assembly(Rocket $rocket, Closure $next): Rocket
    {
        Logger::debug('[alipay][AgreementTransferPlugin] 插件开始装载', ['rocket' => $rocket]);

        $rocket->mergePayload([
            'method' => 'alipay.user.agreement.transfer',
            'biz_content' => array_merge(
                ['target_product_code' => 'CYCLE_PAY_AUTH_P'],
                $rocket->getParams()
            ),
        ]);

        Logger::info('[alipay][AgreementTransferPlugin] 插件装载完毕', ['rocket' => $rocket]);

        return $next($rocket);
    }
}
