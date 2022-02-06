<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserRepository;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class UserService
{
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param UserRepository $repository The repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Create a new user.
     *
     * @param array $data The form data
     *
     * @return int The new user ID
     */
    public function createUser(array $data): int
    {
        // Input validation
        $this->validateNewUser($data);

        // Insert user
        $userId = $this->repository->insertUser($data);

        // Logging here: User created successfully
        //$this->logger->info(sprintf('User created successfully: %s', $userId));

        return $userId;
    }

    public function getUsers($options)
    {
//        les options de filtre, tri, sélection de champs et de pagination
        $order = $options['order'] ?? 'asc';

        $users = $this->repository->getUsers($order);

        $page = $options['page'] ?? 0;
        $filter = $options['filter'] ?? "";
        $champ = $options['champ'] ?? "";


        if (!empty($page)){
            $users = array_slice( $users, 1 * $page , 10 );
        }

        if (!empty($filter)){
            $users = array_filter($users, function($obj) use ($filter) {

                list($userMail, $domain) = explode('@', $obj->email);
                if ($domain == $filter) {
                    return true;
                }
                return false;
            });
        }

        if (!empty($champ)){
            $users = array_map(function($x) use ($champ) {
                return $x[$champ];
            }, $users);
        }

        return $users;
    }


    public function getUser(int $id)
    {
        return $this->repository->getUser($id);
    }

    /**
     * Input validation.
     *
     * @param array $data The form data
     *
     * @throws ValidationException
     *
     * @return void
     */
    private function validateNewUser(array $data): void
    {
        $errors = [];

        // Here you can also use your preferred validation library

        if (empty($data['username'])) {
            $errors['username'] = 'Input required';
        }

        if (empty($data['email'])) {
            $errors['email'] = 'Input required';
        } elseif (filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
            $errors['email'] = 'Invalid email address';
        }

        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }

    public function editUser(array $data, int $id)
    {
        // Input validation
        $this->validateNewUser($data);

        return $this->repository->editUser($data, $id);
    }

    public function deleteUser(int $id)
    {
        // Input validation
        return $this->repository->deleteUser($id);
    }
}
