<?php


namespace App\Repository\User;


use App\Models\User;

interface UsersRepositoryInterface
{
    public function getById(int $id): User;
}
