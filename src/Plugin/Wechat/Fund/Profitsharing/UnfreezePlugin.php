<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Wechat\Fund\Profitsharing;

use Dehim\Pay\Exception\ContainerException;
use Dehim\Pay\Exception\ServiceNotFoundException;
use Dehim\Pay\Pay;
use Dehim\Pay\Plugin\Wechat\GeneralPlugin;
use Dehim\Pay\Rocket;

use function Dehim\Pay\get_wechat_config;

/**
 * @see https://pay.weixin.qq.com/wiki/doc/apiv3/apis/chapter8_1_5.shtml
 */
class UnfreezePlugin extends GeneralPlugin
{
    /**
     * @throws ContainerException
     * @throws ServiceNotFoundException
     */
    protected function doSomething(Rocket $rocket): void
    {
        $payload = $rocket->getPayload();
        $config = get_wechat_config($rocket->getParams());

        if (Pay::MODE_SERVICE === ($config['mode'] ?? null) && !$payload->has('sub_mchid')) {
            $rocket->mergePayload([
                'sub_mchid' => $config['sub_mch_id'] ?? '',
            ]);
        }
    }

    protected function getUri(Rocket $rocket): string
    {
        return 'v3/profitsharing/orders/unfreeze';
    }
}
