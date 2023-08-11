<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Alipay\Trade;

use Closure;
use Dehim\Pay\Contract\PluginInterface;
use Dehim\Pay\Direction\ResponseDirection;
use Dehim\Pay\Exception\ContainerException;
use Dehim\Pay\Exception\ServiceNotFoundException;
use Dehim\Pay\Logger;
use Dehim\Pay\Rocket;
use Dehim\Pay\Traits\SupportServiceProviderTrait;

/**
 * @see https://opendocs.alipay.com/open/02ivbs?scene=common
 */
class WapPayPlugin implements PluginInterface
{
    use SupportServiceProviderTrait;

    /**
     * @throws ContainerException
     * @throws ServiceNotFoundException
     */
    public function assembly(Rocket $rocket, Closure $next): Rocket
    {
        Logger::debug('[alipay][WapPayPlugin] 插件开始装载', ['rocket' => $rocket]);

        $this->loadAlipayServiceProvider($rocket);

        $rocket->setDirection(ResponseDirection::class)
            ->mergePayload([
                'method' => 'alipay.trade.wap.pay',
                'biz_content' => array_merge(
                    [
                        'product_code' => 'QUICK_WAP_PAY',
                    ],
                    $rocket->getParams(),
                ),
            ]);

        Logger::info('[alipay][WapPayPlugin] 插件装载完毕', ['rocket' => $rocket]);

        return $next($rocket);
    }
}
