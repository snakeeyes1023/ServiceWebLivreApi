<?php


namespace App\Action\BookActions;
use App\Domain\Book\Service\BookService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BookAction
{
    private $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface
    {
        $books = $this->bookService->getBooks();


        // Build the HTTP response
        $response->getBody()->write((string)json_encode($books));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}
