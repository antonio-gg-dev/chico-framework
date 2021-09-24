<?php

declare(strict_types=1);

namespace Chico\Router;

final class Route
{
    public const METHOD_CONNECT = 'CONNECT';
    public const METHOD_DELETE = 'DELETE';
    public const METHOD_GET = 'GET';
    public const METHOD_HEAD = 'HEAD';
    public const METHOD_OPTIONS = 'OPTIONS';
    public const METHOD_PATCH = 'PATCH';
    public const METHOD_POST = 'POST';
    public const METHOD_PUT = 'PUT';
    public const METHOD_TRACE = 'TRACE';

    /**
     * @param self::METHOD_* $method
     * @param string $path
     * @param class-string<Controller> $controller
     * @param callable-string $action
     */
    public function __construct(
        private $method,
        private string $path,
        private string $controller,
        private string $action
    ) {
    }

    public function requestMatches(): bool
    {
        if (!$this->methodMatches()) {
            return false;
        }

        if (!$this->pathMatches()) {
            return false;
        }

        return true;
    }

    private function methodMatches(): bool
    {
        $requestMethod = (string) $_SERVER['REQUEST_METHOD'];
        $currentMethod = $this->method;

        return $requestMethod === $currentMethod;
    }

    private function pathMatches(): bool
    {
        $requestUri = (string) $_SERVER['REQUEST_URI'];
        $requestPath = array_values(array_filter(explode('/', parse_url($requestUri, PHP_URL_PATH))));
        $currentPath = array_values(array_filter(explode('/', parse_url($this->path, PHP_URL_PATH))));
        return $requestPath === $currentPath;
    }

    public function run(): string
    {
        return (string) (new $this->controller())
            ->{$this->action}();
    }
}
