<?php

declare(strict_types=1);

namespace Tests\Facades;

use Chico\Facades\Route;
use Tests\TestCase;

class RouteTest extends TestCase
{
    public function test_it_should_respond_if_everything_matches(): void
    {
        $_SERVER['REQUEST_URI'] = 'https://example.org/expected/uri';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->expectOutputString('Expected Output');

        Route::get('expected/uri', StubController::class, 'basicAction');
    }

    public function test_it_should_not_respond_if_the_uri_does_not_matches(): void
    {
        $_SERVER['REQUEST_URI'] = 'https://example.org/other/uri';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->expectOutputString('');

        Route::get('unexpected/uri', StubController::class, 'basicAction');
    }

    public function test_it_should_not_respond_if_the_method_does_not_matches(): void
    {
        $_SERVER['REQUEST_URI'] = 'https://example.org/expected/uri';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->expectOutputString('');

        Route::post('expected/uri', StubController::class, 'basicAction');
    }

    public function test_it_should_pass_one_param_to_the_action(): void
    {
        $_SERVER['REQUEST_URI'] = 'https://example.org/the/expected/param';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->expectOutputString('Expected param is: "expected"');

        Route::get('the/{param}/param', StubController::class, 'actionWithOneParam');
    }

    public function test_it_should_pass_many_param_to_the_action(): void
    {
        $_SERVER['REQUEST_URI'] = 'https://example.org/params/are/first/and/second';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->expectOutputString('Expected params was: "first" and "second"');

        Route::get('params/are/{firstParam}/and/{secondParam}', StubController::class, 'actionWithTwoParams');
    }

    public function test_it_should_pass_one_id_as_param_to_the_action(): void
    {
        $_SERVER['REQUEST_URI'] = 'https://example.org/books/84';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->expectOutputString('Book IS is: "84"');

        Route::get('books/{bookId}', StubController::class, 'actionBookById');
    }
}
