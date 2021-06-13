<?php

namespace App\Providers;

use App\Infrastructure\Eloquent\Country\CountriesRepository;
use App\Infrastructure\Eloquent\User\UsersRepository;
use App\Repository\Country\CountriesRepositoryInterface;
use App\Repository\User\UsersRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UsersRepositoryInterface::class, UsersRepository::class);
        $this->app->bind(CountriesRepositoryInterface::class, CountriesRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
