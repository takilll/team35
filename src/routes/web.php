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
Route::any('/index', [App\Http\Controllers\HobbyController::class, 'list'])->name('hobby.list');

// 趣味新規投稿一覧ページ
Route::any('/regist', [HobbyController::class, 'regist'])->name('hobby.regist');
// 趣味登録処理
Route::post('/regist',      [HobbyController::class, 'store'])->name('hobby.proc');

// 問い合わせ入力ページ
Route::get('/contact', [App\Http\Controllers\HobbyController::class, 'contact'])->name('contact');
Route::post('/confirm', [App\Http\Controllers\HobbyController::class, 'confirm'])->name('confirm');
Route::post('/complete', [App\Http\Controllers\HobbyController::class, 'process'])->name('process');
Route::get('/complete', [App\Http\Controllers\HobbyController::class, 'complete'])->name('complete');
// ユーザー情報編集
Route::get('/user/edit', [App\Http\Controllers\HobbyController::class, 'edit'])->name('user_edit');
Route::post('/user/edit', [App\Http\Controllers\HobbyController::class, 'update'])->name('user_update');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ログイン
Route::get('/login', [App\Http\Controllers\HobbyController::class, 'login'])->name('login');
Route::post('/login/post', [App\Http\Controllers\HobbyController::class, 'post']);
//会員登録
Route::get('/signup', [App\Http\Controllers\HobbyController::class, 'getRegister']);
Route::post('/signup/post', [App\Http\Controllers\HobbyController::class, 'postRegister']);
// ログアウト
Route::get('/logout', [App\Http\Controllers\HobbyController::class, 'logout'])->name('logout');

// ユーザーマイページ
Route::get('/mypage', [App\Http\Controllers\HobbyController::class, 'mypage'])->name('user_mypage');
// 投稿内容の編集と削除
Route::get('/hobby_edit/{id}', [App\Http\Controllers\HobbyController::class, 'hobby_edit'])->name('hobby_edit');
Route::post('/hobby_edit/{id}', [App\Http\Controllers\HobbyController::class, 'hobby_update'])->name('hobby_update');
Route::get('/hobby_delete/{id}', [App\Http\Controllers\HobbyController::class, 'hobby_delete'])->name('hobby_delete');
Route::post('/hobby_delete/{id}', [App\Http\Controllers\HobbyController::class, 'hobby_remove'])->name('hobby_remove');


