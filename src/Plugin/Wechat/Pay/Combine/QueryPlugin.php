<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Wechat\Pay\Combine;

use Dehim\Pay\Exception\Exception;
use Dehim\Pay\Exception\InvalidParamsException;
use Dehim\Pay\Rocket;

/**
 * @see https://pay.weixin.qq.com/wiki/doc/apiv3/apis/chapter5_1_11.shtml
 */
class QueryPlugin extends \Dehim\Pay\Plugin\Wechat\Pay\Common\QueryPlugin
{
    protected function getUri(Rocket $rocket): string
    {
        $payload = $rocket->getPayload();

        if (!$payload->has('combine_out_trade_no') && !$payload->has('transaction_id')) {
            throw new InvalidParamsException(Exception::MISSING_NECESSARY_PARAMS);
        }

        return 'v3/combine-transactions/out-trade-no/'.
            $payload->get('combine_out_trade_no', $payload->get('transaction_id'));
    }
}
