<?php

namespace App\Providers;

use Illuminate\Routing\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::macro('addMeta', function (bool $enabled = false, array $roles = []) {
            $this->action['meta']['enabled'] = $enabled;
            $this->action['meta']['roles'] = $roles;

            return $this;
        });

        Route::macro('getMeta', function () {
            return $this->getAction['meta'];
        });


    }
}
