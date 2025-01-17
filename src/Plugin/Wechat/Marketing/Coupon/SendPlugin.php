<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Wechat\Marketing\Coupon;

use Dehim\Pay\Exception\ContainerException;
use Dehim\Pay\Exception\Exception;
use Dehim\Pay\Exception\InvalidParamsException;
use Dehim\Pay\Exception\ServiceNotFoundException;
use Dehim\Pay\Plugin\Wechat\GeneralPlugin;
use Dehim\Pay\Rocket;

use function Dehim\Pay\get_wechat_config;

/**
 * @see https://pay.weixin.qq.com/wiki/doc/apiv3/apis/chapter9_1_2.shtml
 */
class SendPlugin extends GeneralPlugin
{
    /**
     * @throws ContainerException
     * @throws ServiceNotFoundException
     */
    protected function doSomething(Rocket $rocket): void
    {
        $params = $rocket->getParams();
        $config = get_wechat_config($params);

        if (!$rocket->getPayload()->has('appid')) {
            $rocket->mergePayload(['appid' => $config[$this->getConfigKey($params)] ?? '']);
        }

        if (!$rocket->getPayload()->has('stock_creator_mchid')) {
            $rocket->mergePayload(['stock_creator_mchid' => $config['mch_id']]);
        }

        $rocket->getPayload()->forget('openid');
    }

    /**
     * @throws InvalidParamsException
     */
    protected function getUri(Rocket $rocket): string
    {
        $payload = $rocket->getPayload();

        if (!$payload->has('openid')) {
            throw new InvalidParamsException(Exception::MISSING_NECESSARY_PARAMS);
        }

        return 'v3/marketing/favor/users/'.$payload->get('openid').'/coupons';
    }
}
