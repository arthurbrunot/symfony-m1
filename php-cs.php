<?php

$finder = (new PhpCsFixer\Finder())
    ->in([
        'src',
    ]);

return (new PhpCsFixer\Config())
    ->setIndent("    ")
    ->setLineEnding("\n")
    ->setRiskyAllowed(true)
    ->setRules(
        [
            '@PSR2'                             => true,
            '@Symfony'                          => true,
            'array_syntax'                      => ['syntax' => 'short'],
            'class_attributes_separation'       => [
                'elements' => [
                    'const'    => 'one',
                    'property' => 'one',
                    'method'   => 'one',
                ],
            ],
            'class_definition'                  => ['multi_line_extends_each_single_line' => true],
            'concat_space'                      => ['spacing' => 'one'],
            'fully_qualified_strict_types'      => true,
            'no_leading_import_slash'           => true,
            'ordered_class_elements'            => [
                'order' => [
                    'use_trait',

                    'constant',
                    'constant_public',
                    'constant_protected',
                    'constant_private',

                    'property',
                    'property_static',
                    'property_public',
                    'property_public_static',
                    'property_protected',
                    'property_protected_static',
                    'property_private',
                    'property_private_static',

                    'construct',

                    'method',
                    'public',
                    'method_public',
                    'method_static',
                    'method_public_static',
                    'protected',
                    'method_protected',
                    'method_protected_static',
                    'private',
                    'method_private',
                    'method_private_static',

                    'destruct',
                    'magic',
                    'phpunit',
                ],
            ],
            'phpdoc_align'                      => ['align' => 'left'],
            'single_trait_insert_per_statement' => false,
            'strict_param'                      => true,
        ]
    )
    ->setFinder($finder);