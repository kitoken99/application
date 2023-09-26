<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {

            $multi_auth_guard = multi_auth_guard();

            if(! is_null($multi_auth_guard)) {

                return route($multi_auth_guard .'.login');

            }

            return url('/');
        }

        return null;
    }
}