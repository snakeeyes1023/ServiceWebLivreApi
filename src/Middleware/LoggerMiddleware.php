<?php
namespace App\Middleware;


use App\Domain\User\Service\UserService;
use App\Factory\LoggerFactory;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Handlers\Strategies\RequestHandler;
use Slim\Psr7\Request;
use Slim\Psr7\Response;


class LoggerMiddleware
{
    private $logger;

    public function __construct(LoggerFactory $loggerFactory)
    {
        $this->logger = $loggerFactory
            ->addFileHandler('method.log')
            ->createLogger('RouteLogMiddleware');
    }

    public function __invoke(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler): \Psr\Http\Message\ResponseInterface
    {

        // Cette ligne exécute la requête
        $response = $handler->handle($request);

        $this->logger->info($request->getMethod(). " ". $request->getUri(). " " . (string)json_encode($request->getParsedBody()));

        return $response;
    }
}