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
 * @see https://pay.weixin.qq.com/wiki/doc/apiv3/apis/chapter8_1_2.shtml
 */
class QueryPlugin extends GeneralPlugin
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
        $payload = $rocket->getPayload();
        $config = get_wechat_config($rocket->getParams());

        if (!$payload->has('out_order_no') || !$payload->has('transaction_id')) {
            throw new InvalidParamsException(Exception::MISSING_NECESSARY_PARAMS);
        }

        $url = 'v3/profitsharing/orders/'.
            $payload->get('out_order_no').
            '?transaction_id='.$payload->get('transaction_id');

        if (Pay::MODE_SERVICE === ($config['mode'] ?? null)) {
            $url .= '&sub_mchid='.$payload->get('sub_mchid', $config['sub_mch_id'] ?? '');
        }

        return $url;
    }
}
