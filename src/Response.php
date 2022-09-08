<?php

namespace Majkel\Lambdon;

class Response
{
    public function __construct(
        public readonly int $code,
        public readonly Pair|null $headers,
        public readonly string $body 
    ) {
        
    }
}
