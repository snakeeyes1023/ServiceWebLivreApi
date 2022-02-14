<?php

namespace App\Action\UserActions;

use App\Domain\User\Service\UserService;
use App\Factory\LoggerFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UserEditAction
{
    private $userService;
    private $logger;

    public function __construct(UserService $userService, LoggerFactory $loggerFactory)
    {
        $this->logger = $loggerFactory
        ->addFileHandler('usersLog.log')
        ->createLogger('UserActions');

        $this->userService = $userService;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface
    {
        // Collect input from the HTTP request
        $data = $request->getParsedBody();

        $id = (int)$request->getAttributes()["id"];

        // Invoke the Domain with inputs and retain the result
        $result = $this->userService->editUser($data, $id);

        $this->logger->info("L'usager ". $data["username"] . " as été modifié : " . (string)json_encode($result));

        // Transform the result into the JSON representation

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}
