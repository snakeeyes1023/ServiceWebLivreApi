<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Middleware\BasicAuthMiddleware;
use Slim\App;

return function (App $app) {

    //USER
    $app->get('/user/{id}', \App\Action\UserActions\UserAction::class);

    $app->get('/users', \App\Action\UserActions\UserAction::class);

    $app->get('/', \App\Action\UserActions\HomeAction::class)->setName('home');

    $app->post('/user', \App\Action\UserActions\UserCreateAction::class);

    $app->put('/user/{id}', \App\Action\UserActions\UserEditAction::class);

    $app->delete('/user/{id}', \App\Action\UserActions\UserDeleteAction::class);


    //livre
    $app->get('/books', \App\Action\BookActions\BookAction::class);

    // Documentation de l'api
    $app->get('/docs', \App\Action\Docs\SwaggerUiAction::class);
};

