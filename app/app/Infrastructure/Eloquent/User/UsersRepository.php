<?php


namespace App\Infrastructure\Eloquent\User;


use App\Exceptions\UserNotFoundException;
use App\Models\User;
use App\Repository\User\UsersRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

final class UsersRepository implements UsersRepositoryInterface
{
    private User|Builder $user;

    public function __construct(
        User $user
    )
    {
        $this->user = $user;
    }

    public function getById(int $id): User
    {
        $user = $this->user->find($id);
        if (!$user instanceof User){
            throw new UserNotFoundException(\sprintf('User with id %s not exist', $id));
        }
        return $user;
    }
}
