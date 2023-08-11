<?php

declare(strict_types=1);

namespace Dehim\Pay\Service;

use Dehim\Pay\Contract\ConfigInterface;
use Dehim\Pay\Contract\ServiceProviderInterface;
use Dehim\Pay\Exception\ContainerException;
use Dehim\Pay\Pay;
use Yansongda\Supports\Config;

class ConfigServiceProvider implements ServiceProviderInterface
{
    private array $config = [
        'logger' => [
            'enable' => false,
            'file' => null,
            'identify' => 'yansongda.pay',
            'level' => 'debug',
            'type' => 'daily',
            'max_files' => 30,
        ],
        'http' => [
            'timeout' => 5.0,
            'connect_timeout' => 3.0,
            'headers' => [
                'User-Agent' => 'yansongda/pay-v3',
            ],
        ],
        'mode' => Pay::MODE_NORMAL,
    ];

    /**
     * @throws ContainerException
     */
    public function register(mixed $data = null): void
    {
        $config = new Config(array_replace_recursive($this->config, $data ?? []));

        Pay::set(ConfigInterface::class, $config);
    }
}
