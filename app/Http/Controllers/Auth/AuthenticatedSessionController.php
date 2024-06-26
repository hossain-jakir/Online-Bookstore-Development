<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\MainController;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends MainController
{
    protected $data = [];
    function __construct(){
        $data = [];
        $this->data = array_merge($data, $this->frontendItems());
    }
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('Frontend.Login.index')->with('data', $this->data);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // @check the user role and redirect to the appropriate dashboard
        if (Auth::user()->hasRole('super-admin') || Auth::user()->hasRole('admin')) {
            return redirect()->intended(RouteServiceProvider::BACKEND);
        }else{
            return redirect()->intended(RouteServiceProvider::FRONTEND);
        }

        return redirect()->intended(RouteServiceProvider::FRONTEND);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
