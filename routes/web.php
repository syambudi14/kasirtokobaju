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
    return redirect('/login');
});

Route::get('/login', function () {
    return view('login.index');
});

Route::post('/login', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', function () {
    return view('backend.dashboard.index');
});

Route::get('/cashier', function () {
    return view('backend.cashier.index');
});

Route::get('/products', function () {
    return view('backend.products.index');
});

Route::get('/logout', function () {
    return redirect('/login');
});
