<?php

namespace App\Domain\User\Repository;

use PDO;

/**
 * Repository.
 */
class UserRepository
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

    /**
     * Insert user row.
     *
     * @param array $user The user
     *
     * @return int The new ID
     */
    public function insertUser(array $user): int
    {
        $row = [
            'username' => $user['username'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
        ];

        $sql = "INSERT INTO users SET 
                username=:username, 
                first_name=:first_name, 
                last_name=:last_name, 
                email=:email;";

        $this->connection->prepare($sql)->execute($row);

        return (int)$this->connection->lastInsertId();
    }

    public function getUsers($order)
    {
        $sql = "SELECT * FROM Users order by username $order;";

        $statement =  $this->connection->query($sql);
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getUser($id)
    {
        $sql = "SELECT * FROM Users WHERE id = $id;";

        $statement =  $this->connection->query($sql);
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function editUser(array $user, $id)
    {
        $row = [
            "id"=> $id,
            'username' => $user['username'] ?? "TEST",
            'first_name' => $user['first_name'] ?? "TEST",
            'last_name' => $user['last_name'] ?? "TEST",
            'email' => $user['email'] ?? "TEST",
        ];

        $sql = "UPDATE users SET 
                username=:username, 
                first_name=:first_name, 
                last_name=:last_name, 
                email=:email WHERE id =:id;";

        $this->connection->prepare($sql)->execute($row);

        return $this->getUser($id);
    }

    public function deleteUser(int $id)
    {
        $sql = "DELETE users WHERE id = $id;";

        $this->connection->prepare($sql)->execute();

        $result = [
            'resultat' => "true"
        ];

        return $result;
    }
}

