<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        $multi_auth_guard = multi_auth_guard();
        $intended_url = route($multi_auth_guard .'.dashboard');
        $view_name = $multi_auth_guard .'.auth.verify-email';

        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended($intended_url)
                    : view($view_name);
    }
}