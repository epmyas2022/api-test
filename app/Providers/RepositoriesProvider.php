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

        // model validate  if extends of model class (personal model)


        $this->app->singleton(Personal::class, function ($app) {
            $id = $app['request']->route('personal');
            $personalValidates =  new PersonalRequest();
             $personal = Personal::find($id) ?? new Personal();
            $personalValidates->loadModelValidation($personal);
    
            $personalValidates->validate();
       
        });




        // request validate


    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
