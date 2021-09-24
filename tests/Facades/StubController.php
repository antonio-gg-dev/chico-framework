<?php

declare(strict_types=1);

namespace Tests\Facades;

use Chico\Router\Controller;

final class StubController implements Controller
{
    public function stubGetMethod(): string
    {
        return 'Expected Output';
    }
}
