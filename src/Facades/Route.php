<?php

declare(strict_types=1);

namespace Chico\Facades;

use Chico\Router\Controller;
use Chico\Router\Request;
use Chico\Router\Route as RouteEntity;

final class Route
{
    /**
     * @param string $path
     * @param class-string<Controller> $controller
     * @param callable-string $action
     */
    public static function connect(
        string $path,
        string $controller,
        string $action
    ): void {
        $route = new RouteEntity(
            Request::METHOD_CONNECT,
            $path,
            $controller,
            $action
        );

        if ($route->requestMatches()) {
            echo $route->run();
        }
    }

    /**
     * @param string $path
     * @param class-string<Controller> $controller
     * @param callable-string $action
     */
    public static function delete(
        string $path,
        string $controller,
        string $action
    ): void {
        $route = new RouteEntity(
            Request::METHOD_DELETE,
            $path,
            $controller,
            $action
        );

        if ($route->requestMatches()) {
            echo $route->run();
        }
    }

    /**
     * @param string $path
     * @param class-string<Controller> $controller
     * @param callable-string $action
     */
    public static function get(
        string $path,
        string $controller,
        string $action
    ): void {
        $route = new RouteEntity(
            Request::METHOD_GET,
            $path,
            $controller,
            $action
        );

        if ($route->requestMatches()) {
            echo $route->run();
        }
    }

    /**
     * @param string $path
     * @param class-string<Controller> $controller
     * @param callable-string $action
     */
    public static function head(
        string $path,
        string $controller,
        string $action
    ): void {
        $route = new RouteEntity(
            Request::METHOD_HEAD,
            $path,
            $controller,
            $action
        );

        if ($route->requestMatches()) {
            echo $route->run();
        }
    }

    /**
     * @param string $path
     * @param class-string<Controller> $controller
     * @param callable-string $action
     */
    public static function options(
        string $path,
        string $controller,
        string $action
    ): void {
        $route = new RouteEntity(
            Request::METHOD_OPTIONS,
            $path,
            $controller,
            $action
        );

        if ($route->requestMatches()) {
            echo $route->run();
        }
    }

    /**
     * @param string $path
     * @param class-string<Controller> $controller
     * @param callable-string $action
     */
    public static function patch(
        string $path,
        string $controller,
        string $action
    ): void {
        $route = new RouteEntity(
            Request::METHOD_PATCH,
            $path,
            $controller,
            $action
        );

        if ($route->requestMatches()) {
            echo $route->run();
        }
    }

    /**
     * @param string $path
     * @param class-string<Controller> $controller
     * @param callable-string $action
     */
    public static function post(
        string $path,
        string $controller,
        string $action
    ): void {
        $route = new RouteEntity(
            Request::METHOD_POST,
            $path,
            $controller,
            $action
        );

        if ($route->requestMatches()) {
            echo $route->run();
        }
    }

    /**
     * @param string $path
     * @param class-string<Controller> $controller
     * @param callable-string $action
     */
    public static function put(
        string $path,
        string $controller,
        string $action
    ): void {
        $route = new RouteEntity(
            Request::METHOD_PUT,
            $path,
            $controller,
            $action
        );

        if ($route->requestMatches()) {
            echo $route->run();
        }
    }

    /**
     * @param string $path
     * @param class-string<Controller> $controller
     * @param callable-string $action
     */
    public static function trace(
        string $path,
        string $controller,
        string $action
    ): void {
        $route = new RouteEntity(
            Request::METHOD_TRACE,
            $path,
            $controller,
            $action
        );

        if ($route->requestMatches()) {
            echo $route->run();
        }
    }
}
