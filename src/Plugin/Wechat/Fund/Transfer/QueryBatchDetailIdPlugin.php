<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Wechat\Fund\Transfer;

use Dehim\Pay\Exception\Exception;
use Dehim\Pay\Exception\InvalidParamsException;
use Dehim\Pay\Plugin\Wechat\GeneralPlugin;
use Dehim\Pay\Rocket;

/**
 * @see https://pay.weixin.qq.com/wiki/doc/apiv3/apis/chapter4_3_3.shtml
 */
class QueryBatchDetailIdPlugin extends GeneralPlugin
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
     * @throws InvalidParamsException
     */
    protected function getUri(Rocket $rocket): string
    {
        $payload = $rocket->getPayload();

        if (!$payload->has('batch_id') || !$payload->get('detail_id')) {
            throw new InvalidParamsException(Exception::MISSING_NECESSARY_PARAMS);
        }

        return 'v3/transfer/batches/batch-id/'.
            $payload->get('batch_id').
            '/details/detail-id/'.
            $payload->get('detail_id');
    }

    /**
     * @throws InvalidParamsException
     */
    protected function getPartnerUri(Rocket $rocket): string
    {
        $payload = $rocket->getPayload();

        if (!$payload->has('batch_id') || !$payload->has('detail_id')) {
            throw new InvalidParamsException(Exception::MISSING_NECESSARY_PARAMS);
        }

        return 'v3/partner-transfer/batches/batch-id/'.
            $payload->get('batch_id').
            '/details/detail-id/'.
            $payload->get('detail_id');
    }
}
