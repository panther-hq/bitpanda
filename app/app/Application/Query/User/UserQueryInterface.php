<?php


namespace App\Application\Query\User;


use App\Application\Query\User\Model\User;

interface UserQueryInterface
{
    /**
     * @return User[]
     */
    public function findAll(Filter $filter): array;

    public function getById(int $id): User;
}
