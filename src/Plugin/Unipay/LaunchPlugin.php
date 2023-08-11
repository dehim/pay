<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin\Unipay;

use Closure;
use Dehim\Pay\Contract\PluginInterface;
use Dehim\Pay\Exception\ContainerException;
use Dehim\Pay\Exception\InvalidConfigException;
use Dehim\Pay\Exception\InvalidResponseException;
use Dehim\Pay\Exception\ServiceNotFoundException;
use Dehim\Pay\Logger;
use Dehim\Pay\Rocket;
use Yansongda\Supports\Collection;

use function Dehim\Pay\should_do_http_request;
use function Dehim\Pay\verify_unipay_sign;

class LaunchPlugin implements PluginInterface
{
    /**
     * @throws ContainerException
     * @throws InvalidConfigException
     * @throws InvalidResponseException
     * @throws ServiceNotFoundException
     */
    public function assembly(Rocket $rocket, Closure $next): Rocket
    {
        /* @var Rocket $rocket */
        $rocket = $next($rocket);

        Logger::debug('[unipay][LaunchPlugin] 插件开始装载', ['rocket' => $rocket]);

        if (should_do_http_request($rocket->getDirection())) {
            $response = Collection::wrap($rocket->getDestination());
            $signature = $response->get('signature');
            $response->forget('signature');

            verify_unipay_sign(
                $rocket->getParams(),
                $response->sortKeys()->toString(),
                $signature
            );

            $rocket->setDestination($response);
        }

        Logger::info('[unipay][LaunchPlugin] 插件装载完毕', ['rocket' => $rocket]);

        return $rocket;
    }
}
