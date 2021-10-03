<?php

declare(strict_types=1);

namespace Tests\Facades;

use Chico\Facades\Route;
use Chico\Router\Route as RouteEntity;
use Faker\Factory;
use Generator;
use Tests\TestCase;

class RouteTest extends TestCase
{
    private const PROVIDER_TRIES = 10;

    protected function tearDown(): void
    {
        RouteEntity::reset();

        parent::tearDown();
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
        $faker = Factory::create();
        /** @var string[] $params */
        $params = $faker->unique->words(3);

        $_SERVER['REQUEST_URI'] = "https://example.org/$params[0]/$params[1]/$params[2]";
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->expectOutputString("The params are '$params[0]', '$params[1]' and '$params[2]'!");

        Route::get('{firstParam}/{secondParam}/{thirdParam}', StubController::class, 'manyParamsAction');
    }

    public function test_it_should_pass_associated_params_by_name_to_the_action(): void
    {
        $faker = Factory::create();
        /** @var string[] $params */
        $params = $faker->unique->words(3);

        $_SERVER['REQUEST_URI'] = "https://example.org/$params[0]/$params[1]/$params[2]";
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->expectOutputString("The params are '$params[1]', '$params[0]' and '$params[2]'!");

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
        $faker =  Factory::create();

        for ($try = 0; $try < self::PROVIDER_TRIES; $try++) {
            $randomString = (string) $faker->unique()->word();
            yield $randomString => ['string' => $randomString];
        }
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
        $faker =  Factory::create();

        for ($try = 0; $try < self::PROVIDER_TRIES; $try++) {
            $randomInt = (string) $faker->unique()->randomNumber();
            yield "#$randomInt" => ['int' => $randomInt];
        }
    }

    /** @dataProvider floatProvider */
    public function test_it_should_pass_float_params_to_the_action(string $float): void
    {
        $_SERVER['REQUEST_URI'] = "https://example.org/expected/float/is/$float";
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->expectOutputString("The 'float' param is '$float'!");

        Route::get('expected/float/is/{param}', StubController::class, 'floatParamAction');
    }

    public function floatProvider(): Generator
    {
        $faker =  Factory::create();

        for ($try = 0; $try < self::PROVIDER_TRIES; $try++) {
            $randomFloat = (string) $faker->unique()->randomFloat();
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
