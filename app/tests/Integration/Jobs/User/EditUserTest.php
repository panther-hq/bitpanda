<?php


namespace Tests\Integration\Jobs\User;

use App\Application\Query\User\UserDetailQueryInterface;
use App\Exceptions\UserDetailNotFoundException;
use App\Jobs\User\EditUser;
use App\Jobs\User\EditUserHandler;
use Faker\Factory;
use Tests\TestCase;

final class EditUserTest extends TestCase
{

    public function test_edit_user_where_the_user_exists_and_the_user_details_exist_and_the_country_exists(): void
    {

        $userId = 4;
        $userDetail = $this->app->get(UserDetailQueryInterface::class)->getByUserId($userId);

        $faker = Factory::create();
        $firstName = $faker->firstName;
        $lastName = $faker->lastName;
        $phoneNumber = $faker->phoneNumber;
        $this->assertNotSame($firstName, $userDetail->getFirstName());
        $this->assertNotSame($lastName, $userDetail->getLastName());
        $this->assertNotSame($phoneNumber, $userDetail->getPhoneNumber());

        $editUser = new EditUser(
            $userId,
            1,
            $firstName,
            $lastName,
            $phoneNumber
        );
        EditUserHandler::dispatch($editUser);

        $userDetail = $this->app->get(UserDetailQueryInterface::class)->getByUserId($userId);
        $this->assertSame($firstName, $userDetail->getFirstName());
        $this->assertSame($lastName, $userDetail->getLastName());
        $this->assertSame($phoneNumber, $userDetail->getPhoneNumber());
    }

    public function test_edit_user_where_the_user_exists_and_the_user_details_not_exist_and_the_country_exists(): void
    {

        $userId = 2;
        $faker = Factory::create();
        $firstName = $faker->firstName;
        $lastName = $faker->lastName;
        $phoneNumber = $faker->phoneNumber;

        $editUser = new EditUser(
            $userId,
            1,
            $firstName,
            $lastName,
            $phoneNumber
        );
        $this->expectException(UserDetailNotFoundException::class);
        EditUserHandler::dispatch($editUser);
    }
}
