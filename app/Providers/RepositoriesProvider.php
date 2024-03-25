<?php

namespace App\Providers;

use App\Http\Requests\v1\PersonalRequest;
use Illuminate\Support\ServiceProvider;
use App\Repositories\PersonalRepositoryImpl;
use App\Services\PersonalServices;
use Illuminate\Database\Eloquent\Model;
use App\Models\Personal;

class RepositoriesProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

        $personalRepository = new PersonalRepositoryImpl();
        $personalServices = new PersonalServices($personalRepository);

        $this->app->bind(
            PersonalServices::class,
            function () use ($personalServices) {
                return $personalServices;
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
