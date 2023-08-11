<?php

declare(strict_types=1);

namespace Dehim\Pay\Contract;

use Closure;
use Dehim\Pay\Rocket;

interface PluginInterface
{
    public function assembly(Rocket $rocket, Closure $next): Rocket;
}
