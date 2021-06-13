<?php


namespace App\Application\Query\User;


use App\Application\Query\User\Model\UserDetail;

interface UserDetailQueryInterface
{
    public function getByUserId(int $userId): UserDetail;
}
