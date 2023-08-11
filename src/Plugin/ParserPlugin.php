<?php

declare(strict_types=1);

namespace Dehim\Pay\Plugin;

use Closure;
use Psr\Http\Message\ResponseInterface;
use Dehim\Pay\Contract\PackerInterface;
use Dehim\Pay\Contract\PluginInterface;
use Dehim\Pay\Exception\ContainerException;
use Dehim\Pay\Exception\Exception;
use Dehim\Pay\Exception\InvalidConfigException;
use Dehim\Pay\Exception\ServiceNotFoundException;
use Dehim\Pay\Pay;
use Dehim\Pay\Rocket;

use function Dehim\Pay\get_direction;

class ParserPlugin implements PluginInterface
{
    /**
     * @throws ServiceNotFoundException
     * @throws ContainerException
     * @throws InvalidConfigException
     */
    public function assembly(Rocket $rocket, Closure $next): Rocket
    {
        /* @var Rocket $rocket */
        $rocket = $next($rocket);

        /* @var ResponseInterface $response */
        $response = $rocket->getDestination();

        return $rocket->setDestination(
            get_direction($rocket->getDirection())->parse($this->getPacker($rocket), $response)
        );
    }

    /**
     * @throws ContainerException
     * @throws InvalidConfigException
     * @throws ServiceNotFoundException
     */
    protected function getPacker(Rocket $rocket): PackerInterface
    {
        $packer = Pay::get($rocket->getPacker());

        $packer = is_string($packer) ? Pay::get($packer) : $packer;

        if (!$packer instanceof PackerInterface) {
            throw new InvalidConfigException(Exception::INVALID_PACKER);
        }

        return $packer;
    }
}
