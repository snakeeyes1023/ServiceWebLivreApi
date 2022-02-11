<?php

namespace App\Domain\Book\Repository;

use PDO;

/**
 * Repository.
 */
class BookRepository
{
    /**
     * @var PDO The database connection
     */
    private $connection;

    /**
     * Constructor.
     *
     * @param PDO $connection The database connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getBooks()
    {
        $sql = "SELECT * FROM Books;";

        $statement =  $this->connection->query($sql);
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
}

