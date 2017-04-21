<?php

require __DIR__ . '/../vendor/autoload.php';

// Load environment configuration
$dotenv = new \Dotenv\Dotenv(__DIR__ . '/../');
$dotenv->load();

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