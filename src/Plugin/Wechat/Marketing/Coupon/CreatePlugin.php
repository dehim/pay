<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Wechat\Marketing\Coupon;

use Dehim\Pay\Exception\ContainerException;
use Dehim\Pay\Exception\ServiceNotFoundException;
use Dehim\Pay\Plugin\Wechat\GeneralPlugin;
use Dehim\Pay\Rocket;

use function Dehim\Pay\get_wechat_config;

/**
 * @see https://pay.weixin.qq.com/wiki/doc/apiv3/apis/chapter9_1_1.shtml
 */
class CreatePlugin extends GeneralPlugin
{
    /**
     * @throws ContainerException
     * @throws ServiceNotFoundException
     */
    protected function doSomething(Rocket $rocket): void
    {
        $config = get_wechat_config($rocket->getParams());
        $payload = $rocket->getPayload();

        if (!$payload->has('belong_merchant')) {
            $rocket->mergePayload(['belong_merchant' => $config['mch_id']]);
        }
    }

    protected function getUri(Rocket $rocket): string
    {
        return 'v3/marketing/favor/coupon-stocks';
    }
}
