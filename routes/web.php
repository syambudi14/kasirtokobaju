<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
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

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->middleware('auth');

use App\Http\Controllers\TransactionController;

Route::get('/cashier', [TransactionController::class, 'index'])->middleware('auth');
Route::post('/transactions', [TransactionController::class, 'store'])->middleware('auth');

Route::get('/products', [ProductController::class, 'index'])->middleware('auth');
Route::get('/products/create', [ProductController::class, 'create'])->middleware('auth');
Route::post('/products', [ProductController::class, 'store'])->middleware('auth');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->middleware('auth');
Route::post('/products/{id}/add-stock', [ProductController::class, 'addStock'])->middleware('auth');
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->middleware('auth');
Route::put('/products/{id}', [ProductController::class, 'update'])->middleware('auth');

Route::get('/reports', [\App\Http\Controllers\ReportController::class, 'index'])->middleware('auth');

Route::get('/settings', function () {
    return view('backend.setting.index');
})->middleware('auth');
