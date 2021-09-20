<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in(__DIR__);

return (new Config())
    ->setFinder($finder)
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12' => true,
        'array_indentation' => true,
        'array_syntax' => ['syntax' => 'short'],
        'cast_spaces' => true,
        'clean_namespace' => true,
        'declare_strict_types' => true,
        'fully_qualified_strict_types' => true,
        'global_namespace_import' => true,
        'no_empty_comment' => true,
        'no_unused_imports' => true,
        'php_unit_method_casing' => ['case' => 'snake_case'],
        'psr_autoloading' => true,
        'void_return' => true,
        'trailing_comma_in_multiline' => true
    ]);
