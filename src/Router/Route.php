<?php

declare(strict_types=1);

namespace Chico\Router;

final class Route
{
    /**
     * @param string $uri
     * @param class-string<Controller> $controller
     * @param callable-string $action
     */
    public static function get(
        string $uri,
        string $controller,
        string $action
    ): void {
        if (self::uriMatches($uri)) {
            return;
        }

        echo self::getResponse($controller, $action);
    }

    private static function uriMatches(string $uri): bool
    {
        return $_SERVER['REQUEST_URI'] !== $uri;
    }

    /**
     * @param class-string<Controller> $controller
     * @param callable-string $action
     */
    private static function getResponse(
        string $controller,
        string $action
    ): string {
        return (string) (new $controller())->{$action}();
    }
}
