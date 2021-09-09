<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/user/edit/{id}', [App\Http\Controllers\HobbyController::class, 'edit'])->name('user_edit');
Route::post('/user/edit/{id}', [App\Http\Controllers\HobbyController::class, 'update'])->name('user_update');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
