<?php


namespace App\Action;


use App\Domain\User\Service\UserCreator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UserAction
{
    private $userCreator;

    public function __construct(UserCreator $userCreator)
    {
        $this->userCreator = $userCreator;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {

        // Invoke the Domain with inputs and retain the result
        $users = $this->userCreator->getUsers();

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($users));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}