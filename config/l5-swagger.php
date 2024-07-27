<?php

return [
    'default' => 'default',
    'documentations' => [
        'default' => [
            'api' => [
                'title' => 'Library API',
            ],
            'routes' => [
                'api' => 'api/documentation', // Rota para a documentação da API
                'docs' => 'api/docs',         // Rota para visualizar os docs
            ],
            'paths' => [
                'use_absolute_path' => env('L5_SWAGGER_USE_ABSOLUTE_PATH', true),
                'docs_json' => 'api-docs.json',
                'docs_yaml' => 'api-docs.yaml',
                'format_to_use_for_docs' => env('L5_FORMAT_TO_USE_FOR_DOCS', 'json'),
                'annotations' => [
                    base_path('app/Http/Controllers'),
                ],
            ],
        ],
    ],
    'defaults' => [
        'routes' => [
            'docs' => 'api/docs',
            'oauth2_callback' => 'api/oauth2-callback',
        ],
        'paths' => [
            'docs' => storage_path('api-docs'),
            'views' => base_path('resources/views/vendor/l5-swagger'),
            'base' => env('L5_SWAGGER_BASE_PATH', '/api'), // Ajuste aqui
        ],
        'scanOptions' => [
            'pattern' => '*.php',
            'exclude' => [], // Certifique-se de que essa linha está corretamente configurada como um array vazio
            'open_api_spec_version' => env('L5_SWAGGER_OPEN_API_SPEC_VERSION', \L5Swagger\Generator::OPEN_API_DEFAULT_SPEC_VERSION),
        ],
        'securityDefinitions' => [
            'securitySchemes' => [
                'passport' => [
                    'type' => 'oauth2',
                    'description' => 'Laravel passport oauth2 security.',
                    'in' => 'header',
                    'scheme' => 'https',
                    'flows' => [
                        'password' => [
                            'authorizationUrl' => config('app.url') . '/oauth/authorize',
                            'tokenUrl' => config('app.url') . '/oauth/token',
                            'refreshUrl' => config('app.url') . '/token/refresh',
                            'scopes' => [],
                        ],
                    ],
                ],
                'sanctum' => [
                    'type' => 'apiKey',
                    'description' => 'Enter token in format (Bearer <token>)',
                    'name' => 'Authorization',
                    'in' => 'header',
                ],
            ],
            'security' => [],
        ],
        'generate_always' => env('L5_SWAGGER_GENERATE_ALWAYS', false),
        'generate_yaml_copy' => env('L5_SWAGGER_GENERATE_YAML_COPY', false),
        'proxy' => false,
        'additional_config_url' => null,
        'operations_sort' => env('L5_SWAGGER_OPERATIONS_SORT', null),
        'validator_url' => null,
        'ui' => [
            'display' => [
                'doc_expansion' => env('L5_SWAGGER_UI_DOC_EXPANSION', 'none'),
                'filter' => env('L5_SWAGGER_UI_FILTERS', true),
            ],
            'authorization' => [
                'persist_authorization' => env('L5_SWAGGER_UI_PERSIST_AUTHORIZATION', false),
                'oauth2' => [
                    'use_pkce_with_authorization_code_grant' => false,
                ],
            ],
        ],
        'constants' => [
            'L5_SWAGGER_CONST_HOST' => env('L5_SWAGGER_CONST_HOST', 'http://my-default-host.com'),
        ],
    ],
];
