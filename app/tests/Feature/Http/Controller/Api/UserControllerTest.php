<?php


namespace Tests\Feature\Http\Controller\Api;


use App\Application\Query\User\Model\User;
use App\Application\Query\User\Model\UserDetail;
use App\Application\Query\User\UserDetailQueryInterface;
use App\Application\Query\User\UserQueryInterface;
use App\Exceptions\UserDetailNotFoundException;
use App\Exceptions\UserNotFoundException;
use Faker\Factory;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

final class UserControllerTest extends TestCase
{
    public function test_lists_users(): void
    {
        $data = $this->get('/api/user?isActive=true&iso3=AUT');
        $data->assertJsonCount(2);
        $data->assertStatus(JsonResponse::HTTP_OK);
    }

    public function test_edit_user_where_user_detail_exists(): void
    {
        $userId = 1;
        $user = $this->app->get(UserQueryInterface::class)->getById($userId);
        $this->assertInstanceOf(User::class,$user);

        $userDetail = $this->app->get(UserDetailQueryInterface::class)->getByUserId($user->getId());
        $this->assertInstanceOf(UserDetail::class,$userDetail);

        $faker = Factory::create();
        $firstName = $faker->firstName;
        $lastName = $faker->lastName;
        $phoneNumber = $faker->phoneNumber;
        $response = $this->putJson(\sprintf('/api/user/%s', $userId), [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'phoneNumber' => $phoneNumber,
            'countryId' => 1
        ]);
        $response->assertStatus(JsonResponse::HTTP_OK);
    }

    public function test_edit_user_where_user_detail_not_exists(): void
    {
        $userId = 3;
        $user = $this->app->get(UserQueryInterface::class)->getById($userId);
        $this->assertInstanceOf(User::class,$user);

        $userDetail = false;
        try {
            $userDetail = $this->app->get(UserDetailQueryInterface::class)->getByUserId($user->getId());
        }catch (UserDetailNotFoundException $exception){
        }
        $this->assertFalse($userDetail);

        $faker = Factory::create();
        $firstName = $faker->firstName;
        $lastName = $faker->lastName;
        $phoneNumber = $faker->phoneNumber;
        $response = $this->putJson(\sprintf('/api/user/%s', $userId), [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'phoneNumber' => $phoneNumber,
            'countryId' => 1
        ]);
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    public function test_edit_user_where_user_not_exists(): void
    {
        $userId = 55;
        $user = false;
        try {
            $user = $this->app->get(UserQueryInterface::class)->getById($userId);
        }catch (UserNotFoundException $exception){
        }
        $this->assertFalse($user);

        $faker = Factory::create();
        $firstName = $faker->firstName;
        $lastName = $faker->lastName;
        $phoneNumber = $faker->phoneNumber;
        $response = $this->putJson(\sprintf('/api/user/%s', $userId), [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'phoneNumber' => $phoneNumber,
            'countryId' => 1
        ]);
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    public function test_edit_user_where_country_not_exists(): void
    {
        $userId = 1;
        $faker = Factory::create();
        $firstName = $faker->firstName;
        $lastName = $faker->lastName;
        $phoneNumber = $faker->phoneNumber;
        $response = $this->putJson(\sprintf('/api/user/%s', $userId), [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'phoneNumber' => $phoneNumber,
            'countryId' => 55
        ]);
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    public function test_remove_user_where_user_detail_exists(): void
    {
        $userId = 1;
        $user = $this->app->get(UserQueryInterface::class)->getById($userId);
        $this->assertInstanceOf(User::class,$user);

        $userDetail = $this->app->get(UserDetailQueryInterface::class)->getByUserId($user->getId());
        $this->assertInstanceOf(UserDetail::class,$userDetail);

        $response = $this->delete(\sprintf('/api/user/%s', $userId));
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    public function test_remove_user_where_user_detail_not_exists(): void
    {
        $userId = 3;
        $user = $this->app->get(UserQueryInterface::class)->getById($userId);
        $this->assertInstanceOf(User::class,$user);

        $userDetail = false;
        try {
            $userDetail = $this->app->get(UserDetailQueryInterface::class)->getByUserId($user->getId());
        }catch (UserDetailNotFoundException $exception){
        }
        $this->assertFalse($userDetail);
        $response = $this->delete(\sprintf('/api/user/%s', $userId));
        $response->assertStatus(JsonResponse::HTTP_NO_CONTENT);
    }

    public function test_remove_user_where_user_not_exists(): void
    {
        $userId = 55;
        $user = false;
        try {
            $user = $this->app->get(UserQueryInterface::class)->getById($userId);
        }catch (UserNotFoundException $exception){
        }

        $this->assertFalse($user);
        $response = $this->delete(\sprintf('/api/user/%s', $userId));
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }
}
