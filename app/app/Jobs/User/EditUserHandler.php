<?php

namespace App\Jobs\User;

use App\Repository\Country\CountriesRepositoryInterface;
use App\Repository\User\UsersRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class EditUserHandler implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private EditUser $editUser;

    public function __construct(EditUser $editUser)
    {
        $this->editUser = $editUser;
    }

    public function handle(
        UsersRepositoryInterface $usersRepository,
        CountriesRepositoryInterface $countriesRepository
    ): void
    {
        $user = $usersRepository->getById($this->editUser->getUserId());
        $country = $countriesRepository->getById($this->editUser->getCitizenshipCountryId());

        $user->edit(
            $country->getId(),
            $this->editUser->getFirstName(),
            $this->editUser->getLastName(),
            $this->editUser->getPhoneNumber()
        );
    }
}
