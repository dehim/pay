<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Unipay;

use Closure;
use Dehim\Pay\Contract\PluginInterface;
use Dehim\Pay\Direction\NoHttpRequestDirection;
use Dehim\Pay\Exception\ContainerException;
use Dehim\Pay\Exception\Exception;
use Dehim\Pay\Exception\InvalidConfigException;
use Dehim\Pay\Exception\InvalidResponseException;
use Dehim\Pay\Exception\ServiceNotFoundException;
use Dehim\Pay\Logger;
use Dehim\Pay\Rocket;
use Yansongda\Supports\Collection;
use Yansongda\Supports\Str;

use function Dehim\Pay\verify_unipay_sign;

class CallbackPlugin implements PluginInterface
{
    /**
     * @throws ContainerException
     * @throws InvalidConfigException
     * @throws ServiceNotFoundException
     * @throws InvalidResponseException
     */
    public function assembly(Rocket $rocket, Closure $next): Rocket
    {
        Logger::debug('[unipay][CallbackPlugin] 插件开始装载', ['rocket' => $rocket]);

        $this->formatPayload($rocket);

        $params = $rocket->getParams();
        $signature = $params['signature'] ?? false;

        if (!$signature) {
            throw new InvalidResponseException(Exception::INVALID_RESPONSE_SIGN, '', $params);
        }

        verify_unipay_sign($params, $rocket->getPayload()->sortKeys()->toString(), $signature);

        $rocket->setDirection(NoHttpRequestDirection::class)
            ->setDestination($rocket->getPayload());

        Logger::info('[unipay][CallbackPlugin] 插件装载完毕', ['rocket' => $rocket]);

        return $next($rocket);
    }

    protected function formatPayload(Rocket $rocket): void
    {
        $payload = (new Collection($rocket->getParams()))
            ->filter(fn ($v, $k) => 'signature' != $k && !Str::startsWith($k, '_'));

        $rocket->setPayload($payload);
    }
}
