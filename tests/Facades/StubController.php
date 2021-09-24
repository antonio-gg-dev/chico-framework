<?php

declare(strict_types=1);

namespace Tests\Facades;

use Chico\Router\Controller;

final class StubController implements Controller
{
    public function basicAction(): string
    {
        return 'Expected Output';
    }

    public function actionWithOneParam(string $param): string
    {
        return "Expected param is: \"{$param}\"";
    }

    public function actionWithTwoParams(string $firstParams, string $secondParams): string
    {
        return "Expected params was: \"{$firstParams}\" and \"{$secondParams}\"";
    }

    public function actionBookById(int $bookId): string
    {
        return "Book ID is \"{$bookId}\"";
    }
}
