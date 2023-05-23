<?php

namespace BrainBoxLabs\PersistQuery;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use BrainBoxLabs\PersistQuery\Middleware\Persist;

class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        app('router')->aliasMiddleware('persist-query', Persist::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

