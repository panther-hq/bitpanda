<?php


namespace Tests\Integration\Jobs\User;


use App\Application\Query\User\Model\User;
use App\Application\Query\User\Model\UserDetail;
use App\Application\Query\User\UserDetailQueryInterface;
use App\Application\Query\User\UserQueryInterface;
use App\Exceptions\RuntimeException;
use App\Exceptions\UserDetailNotFoundException;
use App\Exceptions\UserNotFoundException;
use App\Jobs\User\RemoveUser;
use App\Jobs\User\RemoveUserHandler;
use Tests\TestCase;

final class RemoveUserTest extends TestCase
{
    public function test_remove_user_where_user_detail_not_exists(): void
    {
        $userId = 3;
        $user = $this->app->get(UserQueryInterface::class)->getById($userId);
        $this->assertInstanceOf(User::class,$user);
        $userDetail = false;
        try {
            $userDetail = $this->app->get(UserDetailQueryInterface::class)->getByUserId($user->getId());
        } catch (UserDetailNotFoundException $exception){
        }
        $this->assertFalse($userDetail);

        $removeUser = new RemoveUser(
            $userId
        );
        RemoveUserHandler::dispatch($removeUser);
        $user = false;
        try {
            $user = $this->app->get(UserQueryInterface::class)->getById($userId);
        } catch (UserNotFoundException $exception){
        }
        $this->assertFalse($user);
    }

    public function test_remove_user_where_user_detail_exists(): void
    {
        $userId = 4;
        $user = $this->app->get(UserQueryInterface::class)->getById($userId);
        $this->assertInstanceOf(User::class,$user);

        $userDetail = $this->app->get(UserDetailQueryInterface::class)->getByUserId($user->getId());
        $this->assertInstanceOf(UserDetail::class,$userDetail);

        $removeUser = new RemoveUser(
            $userId
        );
        try {
            RemoveUserHandler::dispatch($removeUser);
        }catch (RuntimeException $exception){
        }

        $user = $this->app->get(UserQueryInterface::class)->getById($userId);
        $this->assertInstanceOf(User::class,$user);
    }

}
