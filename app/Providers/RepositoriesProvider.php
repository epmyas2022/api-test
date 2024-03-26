<?php

namespace App\Providers;

use App\Http\Requests\v1\PersonalRequest;
use Illuminate\Support\ServiceProvider;
use App\Repositories\PersonalRepositoryImpl;
use App\Services\PersonalServices;
use App\Repositories\UserRepositoryImpl;
use App\Services\UserServices;
use App\Services\AuthServices;
class RepositoriesProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

        $personalRepository = new PersonalRepositoryImpl();
        $personalServices = new PersonalServices($personalRepository);
        $userRepository = new UserRepositoryImpl();
        $userServices = new UserServices($userRepository);
        $authServices = new AuthServices($userRepository);

        $this->app->bind(
            PersonalServices::class,
            function () use ($personalServices) {
                return $personalServices;
            }
        );

        $this->app->bind(
            UserServices::class,
            function () use ($userServices) {
                return $userServices;
            }
        );

        $this->app->bind(
            AuthServices::class,
            function () use ($authServices) {
                return $authServices;
            }
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
