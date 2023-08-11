<?php

declare(strict_types=1);

namespace Dehim\Pay\Direction;

use Psr\Http\Message\ResponseInterface;
use Dehim\Pay\Contract\DirectionInterface;
use Dehim\Pay\Contract\PackerInterface;
use Dehim\Pay\Exception\Exception;
use Dehim\Pay\Exception\InvalidResponseException;

class OriginResponseDirection implements DirectionInterface
{
    /**
     * @throws InvalidResponseException
     */
    public function parse(PackerInterface $packer, ?ResponseInterface $response): ?ResponseInterface
    {
        if (!is_null($response)) {
            return $response;
        }

        throw new InvalidResponseException(Exception::INVALID_RESPONSE_CODE);
    }
}
