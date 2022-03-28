<?php

namespace App\Action\UserActions;

use App\Domain\User\Service\UserService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UserCreateApiTokenAction
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

        // Validate header authorization
        $authHeader = $request->getHeader('Authorization');

        if (empty($authHeader)) {
            $response->getBody()->write((string)json_encode(['error' => 'Authorization header required']));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(401);
        }
        
        // get user id from authorization header
        $userId = $this->userService->getUserIdFromAuthorizationHeader($authHeader[0]);

        // Generate new api token and save it to database
        if($userId != null){
            
            $apiToken = $this->userService->createApiToken($userId);
            // Transform the result into the JSON representation
            $result = [
                'cle_api' => $apiToken
            ];
        }

        else {
            $result = [
                'error' => 'User not found'
            ];
        }     
        

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
