<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
      View::composer('*', function ($view) {
        $multi_auth_guard = multi_auth_guard();
        if(! is_null($multi_auth_guard)) {
            $view->with('multi_auth_guard', $multi_auth_guard);
        }
    });
    }
}
