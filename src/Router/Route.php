<?php

declare(strict_types=1);

namespace Chico\Router;

use ReflectionClass;
use ReflectionNamedType;

final class Route
{
    private static bool $isResponded = false;

    /**
     * @param Request::METHOD_* $method
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
        if (self::$isResponded) {
            return false;
        }

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
        self::$isResponded = true;

        return (string) (new $this->controller())
            ->{$this->action}(...$this->getParams());
    }

    private function getParams(): array
    {
        $params = [];
        $pathParamKeys = [];
        $pathParamValues = [];

        preg_match($this->getPathPattern(), '/' . $this->path, $pathParamKeys);
        preg_match($this->getPathPattern(), Request::path(), $pathParamValues);

        unset($pathParamValues[0], $pathParamKeys[0]);
        $pathParamKeys = array_map(static fn ($key) => trim($key, '{}'), $pathParamKeys);

        $pathParams = array_combine($pathParamKeys, $pathParamValues);
        $actionParams = (new ReflectionClass($this->controller))
            ->getMethod($this->action)
            ->getParameters();

        foreach ($actionParams as $actionParam) {
            $paramName = $actionParam->getName();
            $paramType = null;

            if (is_a($actionParam->getType(), ReflectionNamedType::class)) {
                $paramType = $actionParam->getType()->getName();
            }

            $value = match ($paramType) {
                'string' => $pathParams[$paramName],
                'int' => (int) $pathParams[$paramName],
                'float' => (float) $pathParams[$paramName],
                'bool' => (bool) json_decode($pathParams[$paramName]),
                null => null,
            };

            $params[$paramName] = $value;
        }

        return $params;
    }

    /** NOTE: Warning! This method is only for testing purposes. */
    public static function reset(): void
    {
        self::$isResponded = false;
    }
}
