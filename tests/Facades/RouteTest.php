<?php

declare(strict_types=1);

namespace Tests\Facades;

use Chico\Facades\Route;
use Chico\Router\Route as RouteEntity;
use Generator;
use Tests\TestCase;

class RouteTest extends TestCase
{
    protected function setUp(): void
    {
        RouteEntity::reset();

        parent::setUp();
    }

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

    public function test_it_should_pass_many_params_to_the_action(): void
    {
        $_SERVER['REQUEST_URI'] = 'https://example.org/this/works/amazingly';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->expectOutputString("The params are 'this', 'works' and 'amazingly'!");

        Route::get('{firstParam}/{secondParam}/{thirdParam}', StubController::class, 'manyParamsAction');
    }

    public function test_it_should_pass_associated_params_by_name_to_the_action(): void
    {
        $_SERVER['REQUEST_URI'] = 'https://example.org/foo/bar/buzz';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->expectOutputString("The params are 'bar', 'foo' and 'buzz'!");

        Route::get('{secondParam}/{firstParam}/{thirdParam}', StubController::class, 'manyParamsAction');
    }

    /** @dataProvider stringProvider */
    public function test_it_should_pass_string_params_to_the_action(string $string): void
    {
        $_SERVER['REQUEST_URI'] = "https://example.org/expected/string/is/$string";
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->expectOutputString("The 'string' param is '$string'!");

        Route::get('expected/string/is/{param}', StubController::class, 'stringParamAction');
    }

    public function stringProvider(): Generator
    {
        yield 'foo' => ['string' => 'foo'];
        yield 'bar' => ['string' => 'bar'];
        yield 'buzz' => ['string' => 'buzz'];
    }

    /** @dataProvider intProvider */
    public function test_it_should_pass_int_params_to_the_action(string $int): void
    {
        $_SERVER['REQUEST_URI'] = "https://example.org/expected/integer/is/$int";
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->expectOutputString("The 'int' param is '$int'!");

        Route::get('expected/integer/is/{param}', StubController::class, 'intParamAction');
    }

    public function intProvider(): Generator
    {
        for ($try = 0; $try < 10; $try++) {
            $randomInt = (string) mt_rand();
            yield "#$randomInt" => ['int' => $randomInt];
        }
    }

    /** @dataProvider floatProvider */
    public function test_it_should_pass_float_params_to_the_action(): void
    {
        $_SERVER['REQUEST_URI'] = 'https://example.org/expected/float/is/8.4';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->expectOutputString("The 'float' param is '8.4'!");

        Route::get('expected/float/is/{param}', StubController::class, 'floatParamAction');
    }

    public function floatProvider(): Generator
    {
        for ($try = 0; $try < 10; $try++) {
            $randomFloat = (string) (mt_rand() / mt_rand(1, 133746));
            yield "#$randomFloat" => ['float' => $randomFloat];
        }
    }

    /** @dataProvider boolProvider */
    public function test_it_should_pass_bool_params_to_the_action(string $given, string $expected): void
    {
        $_SERVER['REQUEST_URI'] = "https://example.org/expected/bool/is/$given";
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->expectOutputString("The 'bool' param is '$expected'!");

        Route::get('expected/bool/is/{param}', StubController::class, 'boolParamAction');
    }

    public function boolProvider(): Generator
    {
        yield 'true' => ['given' => 'true', 'expected' => 'true'];
        yield 'false' => ['given' => 'false', 'expected' => 'false'];
        yield '1' => ['given' => '1', 'expected' => 'true'];
        yield '0' => ['given' => '0', 'expected' => 'false'];
    }

    public function test_it_should_respond_only_the_first_match(): void
    {
        $_SERVER['REQUEST_URI'] = 'https://example.org/expected/uri';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->expectOutputString('Expected!');

        Route::get('expected/uri', StubController::class, 'basicAction');
        Route::get('expected/{param}', StubController::class, 'stringParamAction');
    }
}
