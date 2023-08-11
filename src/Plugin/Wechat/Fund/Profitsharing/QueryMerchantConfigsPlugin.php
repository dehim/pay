<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Wechat\Fund\Profitsharing;

use Dehim\Pay\Exception\ContainerException;
use Dehim\Pay\Exception\Exception;
use Dehim\Pay\Exception\InvalidParamsException;
use Dehim\Pay\Exception\ServiceNotFoundException;
use Dehim\Pay\Pay;
use Dehim\Pay\Plugin\Wechat\GeneralPlugin;
use Dehim\Pay\Rocket;

use function Dehim\Pay\get_wechat_config;

/**
 * @see https://pay.weixin.qq.com/wiki/doc/apiv3_partner/apis/chapter8_1_7.shtml
 */
class QueryMerchantConfigsPlugin extends GeneralPlugin
{
    protected function getMethod(): string
    {
        return 'GET';
    }

    protected function doSomething(Rocket $rocket): void
    {
        $rocket->setPayload(null);
    }

    /**
     * @throws ContainerException
     * @throws InvalidParamsException
     * @throws ServiceNotFoundException
     */
    protected function getUri(Rocket $rocket): string
    {
        $config = get_wechat_config($rocket->getParams());
        $payload = $rocket->getPayload();

        if (Pay::MODE_SERVICE !== ($config['mode'] ?? Pay::MODE_NORMAL)) {
            throw new InvalidParamsException(Exception::METHOD_NOT_SUPPORTED);
        }

        return 'v3/profitsharing/merchant-configs/'.
            $payload->get('sub_mchid', $config['sub_mch_id'] ?? '');
    }
}
