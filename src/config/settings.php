<?php

$isProductionEnvironment = get_app_environment() === 'production';

return [
    'settings' => [
        'displayErrorDetails' => !$isProductionEnvironment, // do not display error details in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
    ],
    'db' => [
        'driver'   => 'pdo_mysql',
        'host'     => env('DB_HOST'),
        'dbname'   => env('DB_NAME'),
        'user'     => env('DB_USER'),
        'password' => env('DB_PASSWORD'),
        'charset'  => env('DB_CHARSET', 'utf8mb4'),
    ],
];
