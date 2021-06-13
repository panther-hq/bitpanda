<?php


namespace Tests\Integration\Infrastructure\Database\Query\User;


use App\Infrastructure\Database\Query\User\UserDetailQuery;
use Tests\TestCase;

final class UserDetailQueryTest extends TestCase
{
    public function test_get_user_detail_by_user_id(): void
    {
        $userDetail = $this->app->get(UserDetailQuery::class)->getByUserId(1);
        $this->assertSame('Alex', $userDetail->getFirstName());
        $this->assertSame('Petro', $userDetail->getLastName());
        $this->assertSame('0043664111111', $userDetail->getPhoneNumber());
    }
}
