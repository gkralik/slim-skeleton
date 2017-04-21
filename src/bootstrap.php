<?php

require __DIR__ . '/../vendor/autoload.php';

// Load functions
require __DIR__ . '/functions.php';

// Load environment configuration if not in production
$applicationEnvironment = get_app_environment();
if ($applicationEnvironment !== 'production') {
    $dotenv = new \Dotenv\Dotenv(__DIR__ . '/../');
    $dotenv->load();
}

// Instantiate the app
$settings = require __DIR__ . '/config/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/config/dependencies.php';

// Register middleware
require __DIR__ . '/config/middleware.php';

// Register routes
require __DIR__ . '/config/routes.php';

return $app;