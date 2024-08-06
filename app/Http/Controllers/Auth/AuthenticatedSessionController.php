<?php

namespace App\Http\Controllers\Auth;

use App\Models\Cart;
use App\Models\Wishlist;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Controllers\Frontend\MainController;

class AuthenticatedSessionController extends MainController
{
    protected $data = [];
    function __construct(Request $request){

    }
    /**
     * Display the login view.
     */
    public function create(Request $request): View
    {
        $data = [];
        $this->data = array_merge($data, $this->frontendItems($request));
        return view('Frontend.Login.index')->with('data', $this->data);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $session_id = $request->session()->get('session_id');

        $request->authenticate();

        $request->session()->regenerate();

        // add user_id to cart table
        $cart = Cart::where('session_id', $session_id)->get();
        if($cart){
            foreach($cart as $c){
                $c->user_id = Auth::user()->id;
                $c->save();
            }
        }

        // user_id to wishlist table
        $wishList = Wishlist::where('session_id', $session_id)->get();
        if($wishList){
            foreach($wishList as $w){
                $w->user_id = Auth::user()->id;
                $w->save();
            }
        }

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
