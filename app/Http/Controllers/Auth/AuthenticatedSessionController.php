<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    private $multi_auth_guard;

    public function __construct()
    {
        $this->multi_auth_guard = multi_auth_guard();
    }

    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view($this->multi_auth_guard .'.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
      $request->authenticate();

      $request->session()->regenerate();

      $redirect_url = route($this->multi_auth_guard .'.dashboard'); // ログイン後のリダイレクト先

      return redirect()->intended($redirect_url);
    }

  /**
   * Destroy an authenticated session.
   */
  public function destroy(Request $request): RedirectResponse
  {
      Auth::guard($this->multi_auth_guard)->logout();

      $request->session()->invalidate();

      $request->session()->regenerateToken();

      return to_route($this->multi_auth_guard .'.login');
  }
}