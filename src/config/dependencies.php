<?php
// DIC configuration

$container = $app->getContainer();

$container['db'] = function($c) {
    $settings = $container->get('settings')['db'];
    
    if (empty($settings['charset'])) {
        // set default charset
        $settings['charset'] = 'utf8mb4';
    }

    $db = \Doctrine\DBAL\DriverManager::getConnection($settings);

    return $db;
};