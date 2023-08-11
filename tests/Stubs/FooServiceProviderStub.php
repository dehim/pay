<?php

declare(strict_types=1);

namespace Dehim\Pay\Tests\Stubs;

use Dehim\Pay\Contract\ServiceProviderInterface;
use Dehim\Pay\Pay;

class FooServiceProviderStub implements ServiceProviderInterface
{
    /**
     * @throws \Dehim\Pay\Exception\ContainerException
     */
    public function register(mixed $data = null): void
    {
        Pay::set('foo', 'bar');
    }
}
