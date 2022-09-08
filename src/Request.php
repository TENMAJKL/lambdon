<?php

namespace Majkel\Lambdon;

class Request
{
    public function __construct(
        public readonly string $path,
        public readonly string $method,
        public readonly Pair|null $query,
        public readonly Pair|null $headers,
        public readonly Pair|null $body
    ) {
        
    }
}
