<?php

use Majkel\Lambdon\Lambdon;
use Majkel\Lambdon\Request;
use Majkel\Lambdon\Response;

use function Majkel\Lambdon\dispatch;
use function Majkel\Lambdon\get;
use function Majkel\Lambdon\post;
use function Majkel\Lambdon\router;

include __DIR__.'/../vendor/autoload.php';

Lambdon::init();

function entry(Request $request): Response
{
    return dispatch(
        router()
            ->bind(fn($router) => get($router, '/', 
                    fn(Request $request) => new Response(200, null, 'Hello!')
            ))
            ->bind(fn($router) => get($router, '/foo', 
                    fn(Request $request) => new Response(200, null, 'bar')
            ))
            ->bind(fn($router) => post($router, '/bar', 
                    fn(Request $request) => new Response(200, null, 'bar')
            )),
        $request
        )
    ;
}
