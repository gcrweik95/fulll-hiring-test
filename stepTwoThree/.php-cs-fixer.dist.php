<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var');

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
    'array_syntax' => ['syntax' => 'short'],
    'declare_strict_types' => true,
    'nullable_type_declaration_for_default_null_value' => true,
    'strict_comparison' => true,
    'strict_param' => true,
    'no_unused_imports' => true,
    'ordered_imports' => ['sort_algorithm' => 'alpha'],
    'method_chaining_indentation' => true,
    'no_superfluous_phpdoc_tags' => true,
    'phpdoc_align' => true,
    'phpdoc_order' => true,
    'phpdoc_types_order' => ['null_adjustment' => 'always_last'],
    'return_type_declaration' => ['space_before' => 'one'],
    ])
    ->setFinder($finder);