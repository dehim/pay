<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Wechat\Pay\Combine;

use Dehim\Pay\Plugin\Wechat\Pay\Common\CombinePrepayPlugin;
use Dehim\Pay\Rocket;

/**
 * @see https://pay.weixin.qq.com/wiki/doc/apiv3/apis/chapter5_1_2.shtml
 */
class H5PrepayPlugin extends CombinePrepayPlugin
{
    protected function getUri(Rocket $rocket): string
    {
        return 'v3/combine-transactions/h5';
    }
}
