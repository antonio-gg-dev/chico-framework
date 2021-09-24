<?php

declare(strict_types=1);

namespace Tests\Facades;

use Chico\Facades\Route;
use Tests\TestCase;

class RouteTest extends TestCase
{
    public function test_it_should_respond_if_the_uri_matches(): void
    {
        $_SERVER['REQUEST_URI'] = 'https://example.org/expected/uri';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->expectOutputString('Expected Output');

        Route::get('expected/uri', StubController::class, 'stubGetMethod');
    }

    public function test_it_should_not_respond_if_the_uri_does_not_matches(): void
    {
        $_SERVER['REQUEST_URI'] = 'https://example.org/some/uri';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->expectOutputString('');

        Route::get('unexpected/uri', StubController::class, 'stubGetMethod');
    }
}
