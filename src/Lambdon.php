<?php

namespace Majkel\Lambdon;

use Exception;
use ReflectionFunction;

class Lambdon
{
    /**
     * Runtime imperative stuff
     */
    public static function init(): void
    {
        register_shutdown_function(function() {
            if (!function_exists('entry')) {
                throw new Exception('Expected entry function');
            }

            $reflection = new ReflectionFunction('entry');
            if (count($args = $reflection->getParameters()) !== 1) {
                throw new Exception('Entry function must expect only 1 argument that is Request');
            }

            if ((string)($args[0]->getType()) !== Request::class) {
                throw new Exception('Entry function must expect only 1 argument that is Request');
            }

            if ((string)($reflection->getReturnType()) !== Response::class) {
                throw new Exception('Entry function must return Response');
            }

            $request = new Request(
                $_SERVER['REQUEST_URI'],
                $_SERVER['REQUEST_METHOD'],
                arr(...$_GET),
                arr(...getallheaders()),
                arr(...$_POST)
            );

            $response = entry($request);

            http_response_code($response->code);
            foreach (self::pairToArray($response->headers) as [$header, $value]) {
                header($header.': '.$value);
            }
            echo $response->body;
        });
    }

    private static function pairToArray(Pair|null $pair): array
    {
        return $pair
            ? [$pair->head, ...(self::pairToArray($pair->tail))]
            : []
        ;
    }
}
