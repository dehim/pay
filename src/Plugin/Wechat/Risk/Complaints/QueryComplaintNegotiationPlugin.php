<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Wechat\Risk\Complaints;

use Dehim\Pay\Exception\Exception;
use Dehim\Pay\Exception\InvalidParamsException;
use Dehim\Pay\Plugin\Wechat\GeneralPlugin;
use Dehim\Pay\Rocket;

/**
 * @see https://pay.weixin.qq.com/wiki/doc/apiv3/apis/chapter10_2_12.shtml
 */
class QueryComplaintNegotiationPlugin extends GeneralPlugin
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
        $complaintId = $payload->get('complaint_id');

        if (is_null($complaintId)) {
            throw new InvalidParamsException(Exception::MISSING_NECESSARY_PARAMS);
        }

        $payload->forget('complaint_id');

        return 'v3/merchant-service/complaints-v2/'.
            $complaintId.
            '/negotiation-historys?'.$payload->query();
    }
}
