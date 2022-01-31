<?php


namespace App\Action;


use App\Domain\User\Service\UserService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UserAction
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {

        $id = (int)$request->getAttributes()["id"];

        $users = null;

        if (isset($id) && !empty($id)){
            $users = $this->userService->getUser($id);
        }
        else{
            $users = $this->userService->getUsers();
        }

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($users));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}