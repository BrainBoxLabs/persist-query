<?php

namespace BrainBoxLabs\PersistQuery;

use Illuminate\Support\Facades\Route;

class TestingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        $this->registerRoutes();
    }

    private function registerRoutes()
    {
        Route::group([
            'prefix' => 'testing',
            'namespace' => 'BrainBoxLabs\PersistQuery\Http\Controllers',
        ], function() {
            $this->loadRoutesFrom(__DIR__.'/../routes/testing.php');
        });
    }
}

