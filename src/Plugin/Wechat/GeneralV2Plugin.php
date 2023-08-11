<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Wechat;

use Dehim\Pay\Exception\ContainerException;
use Dehim\Pay\Exception\ServiceNotFoundException;
use Dehim\Pay\Packer\XmlPacker;
use Dehim\Pay\Rocket;

use function Dehim\Pay\get_wechat_config;

abstract class GeneralV2Plugin extends GeneralPlugin
{
    protected function getHeaders(): array
    {
        return [
            'Content-Type' => 'application/xml',
            'User-Agent' => 'yansongda/pay-v3',
        ];
    }

    /**
     * @throws ContainerException
     * @throws ServiceNotFoundException
     */
    protected function doSomething(Rocket $rocket): void
    {
        $config = get_wechat_config($rocket->getParams());
        $configKey = $this->getConfigKey($rocket->getParams());

        $rocket->setPacker(XmlPacker::class)->mergeParams(['_version' => 'v2']);

        $rocket->mergePayload([
            'appid' => $config[$configKey] ?? '',
            'mch_id' => $config['mch_id'] ?? '',
        ]);
    }

    abstract protected function getUri(Rocket $rocket): string;
}
