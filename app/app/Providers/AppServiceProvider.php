<?php

namespace App\Providers;

use App\Application\Query\Transaction\TransactionQueryInterface;
use App\Application\Query\User\UserDetailQueryInterface;
use App\Application\Query\User\UserQueryInterface;
use App\Infrastructure\Database\Query\Transaction\TransactionQuery;
use App\Infrastructure\Database\Query\User\UserDetailQuery;
use App\Infrastructure\Database\Query\User\UserQuery;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->app->bind(UserQueryInterface::class, UserQuery::class);
        $this->app->bind(UserDetailQueryInterface::class, UserDetailQuery::class);
        $this->app->bind(TransactionQueryInterface::class, TransactionQuery::class);
    }
}
