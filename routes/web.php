<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('Frontend.Home.index');
});

Route::get('/about', function () {
    return view('Frontend.About.index');
});

Route::get('/wishlist', function () {
    return view('Frontend.Wishlist.index');
});

Route::get('/cart', function () {
    return view('Frontend.Cart.index');
});

Route::get('/checkout', function () {
    return view('Frontend.Checkout.index');
});

Route::get('/login', function () {
    return view('Frontend.Login.index');
});

Route::get('/register', function () {
    return view('Frontend.Register.index');
});
