<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Alipay\Tools;

use Dehim\Pay\Plugin\Alipay\GeneralPlugin;
use Dehim\Pay\Rocket;

/**
 * @see https://opendocs.alipay.com/open/02ailc
 */
class SystemOauthTokenPlugin extends GeneralPlugin
{
    protected function doSomethingBefore(Rocket $rocket): void
    {
        $rocket->mergePayload($rocket->getParams());
    }

    protected function getMethod(): string
    {
        return 'alipay.system.oauth.token';
    }
}
