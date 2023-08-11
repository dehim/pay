<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Wechat\Pay\Combine;

use Dehim\Pay\Exception\ContainerException;
use Dehim\Pay\Exception\Exception;
use Dehim\Pay\Exception\InvalidParamsException;
use Dehim\Pay\Exception\ServiceNotFoundException;
use Dehim\Pay\Rocket;
use Yansongda\Supports\Collection;

use function Dehim\Pay\get_wechat_config;

/**
 * @see https://pay.weixin.qq.com/wiki/doc/apiv3/apis/chapter5_1_12.shtml
 */
class ClosePlugin extends \Dehim\Pay\Plugin\Wechat\Pay\Common\ClosePlugin
{
    protected function getUri(Rocket $rocket): string
    {
        $payload = $rocket->getPayload();

        if (!$payload->has('combine_out_trade_no') && !$payload->has('out_trade_no')) {
            throw new InvalidParamsException(Exception::MISSING_NECESSARY_PARAMS);
        }

        return 'v3/combine-transactions/out-trade-no/'.
            $payload->get('combine_out_trade_no', $payload->get('out_trade_no')).
            '/close';
    }

    /**
     * @throws ContainerException
     * @throws ServiceNotFoundException
     */
    protected function doSomething(Rocket $rocket): void
    {
        $config = get_wechat_config($rocket->getParams());

        $rocket->setPayload(new Collection([
            'combine_appid' => $config['combine_appid'] ?? '',
            'sub_orders' => $rocket->getParams()['sub_orders'] ?? [],
        ]));
    }
}
