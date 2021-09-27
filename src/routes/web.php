<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HobbyController;

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

//Auth::routes();

// 投稿一覧ページ
Route::any('/index',        [HobbyController::class, 'list'])->name('hobby.list');

// 趣味新規投稿一覧ページ
Route::any('/hobby/regist', [HobbyController::class, 'regist'])->name('hobby.regist');
// 趣味登録処理
Route::post('/regist',      [HobbyController::class, 'store'])->name('hobby.proc');

// 問い合わせ入力ページ
Route::get('/contact/{id}', [App\Http\Controllers\HobbyController::class, 'contact'])->name('user_contact');
Route::post('/contact/{id}', [App\Http\Controllers\HobbyController::class, 'send'])->name('user_send');
// ユーザー情報編集
Route::get('/user/edit/{id}', [App\Http\Controllers\HobbyController::class, 'edit'])->name('user_edit');
Route::post('/user/edit/{id}', [App\Http\Controllers\HobbyController::class, 'update'])->name('user_update');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ログイン
Route::get('/login', [App\Http\Controllers\HobbyController::class, 'login'])->name('login');
Route::post('/login/post', [App\Http\Controllers\HobbyController::class, 'post']);
//会員登録
Route::get('/signup', [App\Http\Controllers\HobbyController::class, 'getRegister']);
Route::post('/signup/post', [App\Http\Controllers\HobbyController::class, 'postRegister']);

// ユーザーマイページ
Route::get('/user/mypage/{id}', [App\Http\Controllers\HobbyController::class, 'mypage'])->name('user_mypage');
// Route::post('/user/mypage/{id}', [App\Http\Controllers\HobbyController::class, 'update'])->name('user_update');


