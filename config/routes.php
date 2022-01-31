<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Middleware\BasicAuthMiddleware;
use Slim\App;

return function (App $app) {


    $app->get('/user/{id}', \App\Action\UserAction::class);

    $app->get('/users', \App\Action\UserAction::class);

    $app->get('/', \App\Action\HomeAction::class)->setName('home');

    $app->post('/user', \App\Action\UserCreateAction::class);

    $app->put('/user/{id}', \App\Action\UserEditAction::class);

    $app->delete('/user/{id}', \App\Action\UserDeleteAction::class);

    // Documentation de l'api
    $app->get('/docs', \App\Action\Docs\SwaggerUiAction::class);
};

