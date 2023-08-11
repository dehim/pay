<?php

namespace Dehim\Pay\Tests\Direction;

use Dehim\Pay\Exception\Exception;
use Dehim\Pay\Exception\InvalidResponseException;
use Dehim\Pay\Packer\JsonPacker;
use Dehim\Pay\Direction\OriginResponseDirection;
use Dehim\Pay\Tests\TestCase;

class OriginResponseDirectionTest extends TestCase
{
    protected OriginResponseDirection $parser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->parser = new OriginResponseDirection();
    }

    public function testResponseNull()
    {
        self::expectException(InvalidResponseException::class);
        self::expectExceptionCode(Exception::INVALID_RESPONSE_CODE);

        $this->parser->parse(new JsonPacker(), null);
    }
}
