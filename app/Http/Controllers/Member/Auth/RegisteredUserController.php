<?php

namespace App\Http\Controllers\Member\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
  private $multi_auth_guard;

    public function __construct()
    {
        $this->multi_auth_guard = multi_auth_guard();
    }
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view($this->multi_auth_guard .'.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.Member::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = Member::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        $redirect_url = route($this->multi_auth_guard .'.dashboard'); // ログイン後のリダイレクト先

        return redirect()->intended($redirect_url);
    }
}
