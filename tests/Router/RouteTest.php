<?php

declare(strict_types=1);

namespace Tests\Router;

use Tests\TestCase;

class RouteTest extends TestCase
{
    protected function setUp(): void
    {
        $_SERVER['REQUEST_URI'] = 'This works?';

        parent::setUp();
    }

    public function test_it_should_work(): void
    {
        $this->assertSame('This works?', $_SERVER['REQUEST_URI']);
    }
}
