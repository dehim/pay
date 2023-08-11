<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Wechat\Pay\Common;

use Closure;
use Dehim\Pay\Contract\PluginInterface;
use Dehim\Pay\Exception\ContainerException;
use Dehim\Pay\Exception\Exception;
use Dehim\Pay\Exception\InvalidConfigException;
use Dehim\Pay\Exception\InvalidResponseException;
use Dehim\Pay\Exception\ServiceNotFoundException;
use Dehim\Pay\Logger;
use Dehim\Pay\Pay;
use Dehim\Pay\Rocket;
use Yansongda\Supports\Collection;
use Yansongda\Supports\Config;
use Yansongda\Supports\Str;

use function Dehim\Pay\get_wechat_config;
use function Dehim\Pay\get_wechat_sign;

class InvokePrepayPlugin implements PluginInterface
{
    /**
     * @throws ContainerException
     * @throws InvalidResponseException
     * @throws ServiceNotFoundException
     */
    public function assembly(Rocket $rocket, Closure $next): Rocket
    {
        /* @var Rocket $rocket */
        $rocket = $next($rocket);

        Logger::debug('[wechat][InvokePrepayPlugin] 插件开始装载', ['rocket' => $rocket]);

        $destination = $rocket->getDestination();

        $prepayId = $destination->get('prepay_id');

        if (is_null($prepayId)) {
            Logger::error('[wechat][InvokePrepayPlugin] 预下单失败：响应缺少 prepay_id 参数，请自行检查参数是否符合微信要求', $destination->all());

            throw new InvalidResponseException(Exception::RESPONSE_MISSING_NECESSARY_PARAMS, $destination->get('message', '预下单失败：响应缺少 prepay_id 参数，请自行检查参数是否符合微信要求'), $destination->all());
        }

        $config = $this->getInvokeConfig($rocket, $prepayId);

        $rocket->setDestination($config);

        Logger::info('[wechat][InvokePrepayPlugin] 插件装载完毕', ['rocket' => $rocket]);

        return $rocket;
    }

    /**
     * @throws ContainerException
     * @throws ServiceNotFoundException
     * @throws \Exception
     */
    protected function getInvokeConfig(Rocket $rocket, string $prepayId): Config
    {
        $config = new Config([
            'appId' => $this->getAppId($rocket),
            'timeStamp' => time().'',
            'nonceStr' => Str::random(32),
            'package' => 'prepay_id='.$prepayId,
            'signType' => 'RSA',
        ]);

        $config->set('paySign', $this->getSign($config, $rocket->getParams()));

        return $config;
    }

    /**
     * @throws ContainerException
     * @throws InvalidConfigException
     * @throws ServiceNotFoundException
     */
    protected function getSign(Collection $invokeConfig, array $params): string
    {
        $contents = $invokeConfig->get('appId', '')."\n".
            $invokeConfig->get('timeStamp', '')."\n".
            $invokeConfig->get('nonceStr', '')."\n".
            $invokeConfig->get('package', '')."\n";

        return get_wechat_sign($params, $contents);
    }

    /**
     * @throws ContainerException
     * @throws ServiceNotFoundException
     */
    protected function getAppId(Rocket $rocket): string
    {
        $config = get_wechat_config($rocket->getParams());
        $payload = $rocket->getPayload();

        if (Pay::MODE_SERVICE === ($config['mode'] ?? null) && $payload->has('sub_appid')) {
            return $payload->get('sub_appid', '');
        }

        return $config[$this->getConfigKey()] ?? '';
    }

    protected function getConfigKey(): string
    {
        return 'mp_app_id';
    }
}
