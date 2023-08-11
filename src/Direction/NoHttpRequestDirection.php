<?php

declare(strict_types=1);

namespace Dehim\Pay\Direction;

use Psr\Http\Message\ResponseInterface;
use Dehim\Pay\Contract\DirectionInterface;
use Dehim\Pay\Contract\PackerInterface;

class NoHttpRequestDirection implements DirectionInterface
{
    public function parse(PackerInterface $packer, ?ResponseInterface $response): ?ResponseInterface
    {
        return $response;
    }
}
