<?php

namespace Majkel\Lambdon;

use Closure;

class Router implements Monad
{
    public function __construct(
        public readonly Pair|null $routes
    ) {
        
    }

    public function bind(Closure $f): Monad
    {
        return $f($this->routes);
    }
}
