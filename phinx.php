<?php

// Load functions
require __DIR__ . '/src/functions.php';

// Load environment configuration if not in production
$applicationEnvironment = get_app_environment();
if ($applicationEnvironment !== 'production') {
    $dotenv = new \Dotenv\Dotenv(__DIR__ . '/../');
    $dotenv->load();
}

return [
    'paths'                => [
        'migrations' => 'migrations'
    ],
    'environments'         => [
        'default_migration_table' => 'migrations',
        'default_database'        => 'default',
        'default'                     => [
            'adapter' => 'mysql',
            'host'    => env('DB_HOST'),
            'name'    => env('DB_NAME'),
            'user'    => env('DB_USER'),
            'pass'    => env('DB_PASSWORD'),
        ],
    ],
];