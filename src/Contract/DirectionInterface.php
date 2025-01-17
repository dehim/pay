<?php

declare(strict_types=1);

namespace Dehim\Pay\Contract;

use Psr\Http\Message\ResponseInterface;

interface DirectionInterface
{
    public function parse(PackerInterface $packer, ?ResponseInterface $response): mixed;
}
