<?php

namespace Majkel\Lambdon;

class Pair
{
    public function __construct(
        public readonly mixed $head,
        public readonly Pair|null $tail
    ) {
        
    }
}
