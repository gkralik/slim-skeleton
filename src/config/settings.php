<?php

$isProductionEnvironment = get_app_environment() === 'production';

return [
    'settings' => [
        'displayErrorDetails' => !$isProductionEnvironment, // do not display error details in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
    ],
];
