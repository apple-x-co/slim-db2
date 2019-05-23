<?php
return [
    'settings' => [
        'determineRouteBeforeAppMiddleware' => false,
        'debug'                             => (bool)getenv('DEBUG'),
        'displayErrorDetails'               => (bool)getenv('DISPLAY_ERRORS'), // set to false in production
        'addContentLengthHeader'            => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer'                          => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // View settings
        'view'                              => [
            'template_path' => __DIR__ . '/../templates/',
            'twig'          => [
                'cache'       => __DIR__ . '/../cache/templates/',
                'debug'       => (bool)getenv('DEBUG'),
                'auto_reload' => true,
            ],
        ],

        // DB
        'doctrine' => [
            'meta' => [
                'entity_path' => [__DIR__ . '/../src/Entity/'],
                'auto_generate_proxies' => true,
                'proxy_dir' =>  __DIR__ . '/../cache/doctrine-proxies/',
                'cache' => null,
                'cache_dir' => __DIR__ . '/../cache/doctrine/'
            ],
            'connection' => [
                'url' => getenv('DATABASE_URL')
            ]
        ],

        // Monolog settings
        'logger'                            => [
            'name'  => 'slim-app',
            'path'  => __DIR__ . '/../logs/app.log',
            'level' => (bool)getenv('DEBUG') ? \Monolog\Logger::DEBUG : \Monolog\Logger::ERROR,
        ],

        // debugbar
        'debugbar' => [
            'storage' => [
                'enabled' => true,
                'path' => __DIR__. '/../logs/debug/',
            ],
        ],
    ],
];
