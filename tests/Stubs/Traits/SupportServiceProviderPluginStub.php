<?php

namespace Dehim\Pay\Tests\Stubs\Traits;

use Dehim\Pay\Rocket;
use Dehim\Pay\Traits\SupportServiceProviderTrait;

class SupportServiceProviderPluginStub
{
    use SupportServiceProviderTrait;

    public function assembly(Rocket $rocket)
    {
        $this->loadAlipayServiceProvider($rocket);
    }
}
