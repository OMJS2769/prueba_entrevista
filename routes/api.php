<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureTokenIsValid;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('login',[App\Http\Controllers\UserController::class,'login']);
Route::middleware([EnsureTokenIsValid::class])->get('index_customer',[App\Http\Controllers\CustomerController::class,'index']);
Route::middleware([EnsureTokenIsValid::class])->post('store_customer',[App\Http\Controllers\CustomerController::class,'store']);
Route::middleware([EnsureTokenIsValid::class])->delete('destroy_customer',[App\Http\Controllers\CustomerController::class,'destroy']);
