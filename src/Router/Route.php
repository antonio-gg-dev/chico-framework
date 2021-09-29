<?php

declare(strict_types=1);

namespace Chico\Router;

final class Route
{
    /**
     * @param Request::METHOD_* $method
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
        return Request::method() === $this->method;
    }

    private function pathMatches(): bool
    {
        return (bool) preg_match($this->getPathPattern(), Request::path());
    }

    private function getPathPattern(): string
    {
        $pattern = preg_replace('#({.*})#U', '(.*)', $this->path);
        return '#^/' . $pattern . '$#';
    }

    public function run(): string
    {
        return (string) (new $this->controller())
            ->{$this->action}(...$this->getParams());
    }

    private function getParams(): array
    {
        $params = [];

        preg_match($this->getPathPattern(), Request::path(), $params);

        unset($params[0]);

        return $params;
    }
}
