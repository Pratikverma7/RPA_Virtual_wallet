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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

//users
Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('home');
Route::get('user/login', [App\Http\Controllers\UserController::class, 'login']);
Route::get('user/dashboard', [App\Http\Controllers\UserController::class, 'dashboard']);
Route::get('credit', [App\Http\Controllers\UserController::class, 'credit']);
Route::get('debit', [App\Http\Controllers\UserController::class, 'debit']);
Route::post('user/register', [App\Http\Controllers\UserController::class,'store']);
Route::post('user/logincheck', [App\Http\Controllers\UserController::class,'logincheck']);
Route::post('transction/credit', [App\Http\Controllers\UserController::class,'transctioncredit']);
Route::get('logout', [App\Http\Controllers\UserController::class,'logout']);



