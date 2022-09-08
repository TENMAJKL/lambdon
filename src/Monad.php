<?php

namespace Majkel\Lambdon;

use Closure;

interface Monad
{
    public function bind(Closure $f): Monad;
}
