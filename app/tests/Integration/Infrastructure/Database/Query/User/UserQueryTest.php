<?php


namespace Tests\Integration\Infrastructure\Database\Query\User;


use App\Application\Query\User\Filter;
use App\Application\Query\User\Model\User;
use App\Infrastructure\Database\Query\User\UserQuery;
use Tests\TestCase;

final class UserQueryTest extends TestCase
{
    public function test_find_all_users(): void
    {
        $filter = (new Filter())
            ->setActive(true)
            ->setIso3('AUT');
        $users = $this->app->get(UserQuery::class)->findAll($filter);
        $this->assertCount(2, $users);
    }

    public function test_get_user_by_id(): void
    {
        $user = $this->app->get(UserQuery::class)->getById(1);
        $this->assertInstanceOf(User::class, $user);
    }
}
