<?php

namespace App\Domain\Book\Service;

use App\Domain\Book\Repository\BookRepository;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class BookService
{
    /**
     * @var BookRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param BookRepository The repository
     */
    public function __construct(BookRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Create a new user.
     *
     * @param array $data The form data
     *
     * @return array
     */


    public function getBooks()
    {
        // les options de filtre, tri, sélection de champs et de pagination
        $books = $this->repository->getBooks();


        return $books;
    }
}
