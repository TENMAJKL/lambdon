<?php

namespace Majkel\Lambdon;

use Closure;
use TypeError;

/**
 * Imperative syntax sugar
 */
function arr(mixed ...$values): Pair|null
{
    $pair = null;
    foreach (array_reverse($values) as $value) { 
        $pair = new Pair($value, $pair);
    }

    return $pair;
}

function pair(mixed $head, Pair|null $tail): Pair
{
    return new Pair($head, $tail);
}

function head(Pair $pair): mixed
{
    return $pair->head;
}

function tail(Pair $pair): Pair|null
{
    return $pair->tail;
}

function filter(Pair|null $pair, Closure $filter): Pair|null
{
    return $pair
        ? (
            $filter($pair->head) 
            ? pair($pair->head, filter($pair->tail, $filter)) 
            : filter($pair->tail, $filter)
          )
        : null
    ;
}

function get(Pair|null $routes, string $path, Closure $action): Router
{
    return new Router(pair(['GET', $path, $action], $routes));
}

function post(Pair|null $routes, string $path, Closure $action): Router
{
    return new Router(pair(['POST', $path, $action], $routes));
}

function dispatch(Router $router, Request $request): Response
{
    /** where */
    $pathFilter = filter($router->routes, fn(array $route) => $route[1] == $request->path);
    $methodFilter = 
        $pathFilter 
        ? filter($pathFilter, fn(array $route) => $route[0] == $request->method) 
        : pair([2 =>
                fn(Request $request) => new Response(404, null, '404 - Not found')
            ], null)
    ;
    /** endwhere */

    return 
        $methodFilter
        ? head($methodFilter)[2]($request)
        : new Response(400, null, '400 - Bad request')
    ;
}

function router(): Router
{
    return new Router(null);
}


