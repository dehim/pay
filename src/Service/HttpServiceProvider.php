<?php

declare(strict_types=1);

namespace Dehim\Pay\Service;

use GuzzleHttp\Client;
use Dehim\Pay\Contract\ConfigInterface;
use Dehim\Pay\Contract\HttpClientInterface;
use Dehim\Pay\Contract\ServiceProviderInterface;
use Dehim\Pay\Exception\ContainerException;
use Dehim\Pay\Exception\ServiceNotFoundException;
use Dehim\Pay\Pay;
use Yansongda\Supports\Config;

class HttpServiceProvider implements ServiceProviderInterface
{
    /**
     * @throws ContainerException
     * @throws ServiceNotFoundException
     */
    public function register(mixed $data = null): void
    {
        /* @var Config $config */
        $config = Pay::get(ConfigInterface::class);

        if (class_exists(Client::class)) {
            $service = new Client($config->get('http', []));

            Pay::set(HttpClientInterface::class, $service);
        }
    }
}
