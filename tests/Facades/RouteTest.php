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

        $this->expectOutputString('Expected!');

        Route::get('expected/uri', StubController::class, 'basicAction');
    }

    public function test_it_should_not_respond_if_the_uri_does_not_matches(): void
    {
        $_SERVER['REQUEST_URI'] = 'https://example.org/unexpected/uri';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->expectOutputString('');

        Route::get('other/uri', StubController::class, 'basicAction');
    }

    public function test_it_should_not_respond_if_the_method_does_not_matches(): void
    {
        $_SERVER['REQUEST_URI'] = 'https://example.org/expected/uri';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->expectOutputString('');

        Route::post('expected/uri', StubController::class, 'basicAction');
    }

    public function test_it_should_pass_many_param_to_the_action(): void
    {
        $_SERVER['REQUEST_URI'] = 'https://example.org/this/works/amazingly';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->expectOutputString("The params are 'this', 'works' and 'amazingly'!");

        Route::get('{firstParam}/{secondParam}/{thirdParam}', StubController::class, 'manyParamsAction');
    }

    public function test_it_should_pass_string_params(): void
    {
        $_SERVER['REQUEST_URI'] = 'https://example.org/expected/string/is/awesome';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->expectOutputString("The 'string' param is 'awesome'!");

        Route::get('expected/string/is/{param}', StubController::class, 'stringParamAction');
    }

    public function test_it_should_pass_int_params(): void
    {
        $_SERVER['REQUEST_URI'] = 'https://example.org/expected/integer/is/84';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->expectOutputString("The 'integer' param is '84'!");

        Route::get('expected/integer/is/{param}', StubController::class, 'intParamAction');
    }

    public function test_it_should_pass_float_params(): void
    {
        $_SERVER['REQUEST_URI'] = 'https://example.org/expected/float/is/8.4';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->expectOutputString("The 'double' param is '8.4'!");

        Route::get('expected/float/is/{param}', StubController::class, 'floatParamAction');
    }

    public function test_it_should_pass_bool_params(): void
    {
        $_SERVER['REQUEST_URI'] = 'https://example.org/expected/bool/is/true';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->expectOutputString("The 'boolean' param is 'true'!");

        Route::get('expected/bool/is/{param}', StubController::class, 'boolParamAction');
    }
}
