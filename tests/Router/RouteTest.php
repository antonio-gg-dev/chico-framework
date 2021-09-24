<?php

declare(strict_types=1);

namespace Tests\Router;

use Chico\Router\Controller;
use Chico\Router\Route;
use Tests\TestCase;

class RouteTest extends TestCase
{
    public function test_it_should_respond_if_the_uri_matches(): void
    {
        $_SERVER['REQUEST_URI'] = 'expected/uri';

        $this->expectOutputString('Expected Output');

        Route::get('expected/uri', StubController::class, 'stubGetMethod');
    }

    public function test_it_should_not_respond_if_the_uri_does_not_matches(): void
    {
        $_SERVER['REQUEST_URI'] = 'some/uri';

        $this->expectOutputString('');

        Route::get('unexpected/uri', StubController::class, 'stubGetMethod');
    }
}

final class StubController implements Controller
{
    public function stubGetMethod(): string
    {
        return 'Expected Output';
    }
}
