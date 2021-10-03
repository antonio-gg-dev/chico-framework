<?php

declare(strict_types=1);

namespace Chico\Router;

final class Request
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

    /** @return self::METHOD_* */
    public static function method(): mixed
    {
        /** @var self::METHOD_* */
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function path(): string
    {
        return (string) parse_url(
            (string) $_SERVER['REQUEST_URI'],
            PHP_URL_PATH
        );
    }
}
