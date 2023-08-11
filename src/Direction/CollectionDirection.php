<?php

declare(strict_types=1);

namespace Dehim\Pay\Direction;

use Psr\Http\Message\ResponseInterface;
use Dehim\Pay\Contract\DirectionInterface;
use Dehim\Pay\Contract\PackerInterface;
use Dehim\Pay\Exception\Exception;
use Dehim\Pay\Exception\InvalidResponseException;
use Yansongda\Supports\Collection;

class CollectionDirection implements DirectionInterface
{
    /**
     * @throws InvalidResponseException
     */
    public function parse(PackerInterface $packer, ?ResponseInterface $response): Collection
    {
        if (is_null($response)) {
            throw new InvalidResponseException(Exception::RESPONSE_NONE);
        }

        $body = (string) $response->getBody();

        if (!is_null($result = $packer->unpack($body))) {
            return new Collection($result);
        }

        throw new InvalidResponseException(Exception::UNPACK_RESPONSE_ERROR, 'Unpack Response Error', ['body' => $body, 'response' => $response]);
    }
}
