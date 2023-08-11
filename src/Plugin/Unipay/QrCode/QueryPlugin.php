<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Unipay\QrCode;

use Dehim\Pay\Exception\ContainerException;
use Dehim\Pay\Exception\ServiceNotFoundException;
use Dehim\Pay\Pay;
use Dehim\Pay\Rocket;

use function Dehim\Pay\get_unipay_config;

/**
 * @see https://open.unionpay.com/tjweb/acproduct/APIList?acpAPIId=792&apiservId=468&version=V2.2&bussType=0
 */
class QueryPlugin extends \Dehim\Pay\Plugin\Unipay\OnlineGateway\QueryPlugin
{
    /**
     * @throws ContainerException
     * @throws ServiceNotFoundException
     */
    protected function getUri(Rocket $rocket): string
    {
        $config = get_unipay_config($rocket->getParams());

        if (Pay::MODE_SANDBOX === ($config['mode'] ?? Pay::MODE_NORMAL)) {
            return 'https://101.231.204.80:5000/gateway/api/backTransReq.do';
        }

        return parent::getUri($rocket);
    }
}
