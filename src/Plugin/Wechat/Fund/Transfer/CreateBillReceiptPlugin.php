<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Wechat\Fund\Transfer;

use Dehim\Pay\Exception\Exception;
use Dehim\Pay\Exception\InvalidParamsException;
use Dehim\Pay\Plugin\Wechat\GeneralPlugin;
use Dehim\Pay\Rocket;

/**
 * @see https://pay.weixin.qq.com/wiki/doc/apiv3/apis/chapter4_3_7.shtml
 */
class CreateBillReceiptPlugin extends GeneralPlugin
{
    /**
     * @throws InvalidParamsException
     */
    protected function doSomething(Rocket $rocket): void
    {
        $payload = $rocket->getPayload();

        if (!$payload->has('out_batch_no')) {
            throw new InvalidParamsException(Exception::MISSING_NECESSARY_PARAMS);
        }
    }

    protected function getUri(Rocket $rocket): string
    {
        return 'v3/transfer/bill-receipt';
    }
}
