<?php
// Routes

$app->get('/[{name}]', function ($request, $response, $args) {
    return $response = $response->withJson(['hello' => $args['name'] ?? 'world']);
});
