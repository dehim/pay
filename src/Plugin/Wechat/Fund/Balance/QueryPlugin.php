<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Wechat\Fund\Balance;

use Dehim\Pay\Exception\Exception;
use Dehim\Pay\Exception\InvalidParamsException;
use Dehim\Pay\Plugin\Wechat\GeneralPlugin;
use Dehim\Pay\Rocket;

class QueryPlugin extends GeneralPlugin
{
    protected function getMethod(): string
    {
        return 'GET';
    }

    protected function doSomething(Rocket $rocket): void
    {
    }

    /**
     * @throws InvalidParamsException
     */
    protected function getUri(Rocket $rocket): string
    {
        $payload = $rocket->getPayload();

        if (!$payload->has('account_type')) {
            throw new InvalidParamsException(Exception::MISSING_NECESSARY_PARAMS);
        }

        return 'v3/merchant/fund/balance/'.
            $payload->get('account_type');
    }
}
