<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Wechat\Pay\Common;

use Dehim\Pay\Exception\ContainerException;
use Dehim\Pay\Exception\Exception;
use Dehim\Pay\Exception\InvalidParamsException;
use Dehim\Pay\Exception\ServiceNotFoundException;
use Dehim\Pay\Plugin\Wechat\GeneralPlugin;
use Dehim\Pay\Rocket;

use function Dehim\Pay\get_wechat_config;

class QueryPlugin extends GeneralPlugin
{
    /**
     * @throws ContainerException
     * @throws ServiceNotFoundException
     * @throws InvalidParamsException
     */
    protected function getUri(Rocket $rocket): string
    {
        $config = get_wechat_config($rocket->getParams());
        $payload = $rocket->getPayload();

        if ($payload->has('transaction_id')) {
            return 'v3/pay/transactions/id/'.
                $payload->get('transaction_id').
                '?mchid='.($config['mch_id'] ?? '');
        }

        if ($payload->has('out_trade_no')) {
            return 'v3/pay/transactions/out-trade-no/'.
                $payload->get('out_trade_no').
                '?mchid='.($config['mch_id'] ?? '');
        }

        throw new InvalidParamsException(Exception::MISSING_NECESSARY_PARAMS);
    }

    /**
     * @throws ContainerException
     * @throws ServiceNotFoundException
     * @throws InvalidParamsException
     */
    protected function getPartnerUri(Rocket $rocket): string
    {
        $config = get_wechat_config($rocket->getParams());
        $payload = $rocket->getPayload();

        if ($payload->has('transaction_id')) {
            return 'v3/pay/partner/transactions/id/'.
                $payload->get('transaction_id').
                '?sp_mchid='.($config['mch_id'] ?? '').
                '&sub_mchid='.$payload->get('sub_mchid', $config['sub_mch_id'] ?? null);
        }

        if ($payload->has('out_trade_no')) {
            return 'v3/pay/partner/transactions/out-trade-no/'.
                $payload->get('out_trade_no').
                '?sp_mchid='.($config['mch_id'] ?? '').
                '&sub_mchid='.$payload->get('sub_mchid', $config['sub_mch_id'] ?? null);
        }

        throw new InvalidParamsException(Exception::MISSING_NECESSARY_PARAMS);
    }

    protected function getMethod(): string
    {
        return 'GET';
    }

    protected function doSomething(Rocket $rocket): void
    {
        $rocket->setPayload(null);
    }
}
