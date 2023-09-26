<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        $multi_auth_guard = multi_auth_guard();
        $intended_url = route($multi_auth_guard .'.dashboard');

        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended($intended_url);
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
