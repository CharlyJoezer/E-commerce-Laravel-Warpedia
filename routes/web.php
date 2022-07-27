<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

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

// HOME VIEW ROUTE
Route::get('/', [HomeController::class, 'homeView']);

// REGISTER VIEW
Route::get('/register', [UserController::class, 'viewUserRegister']);

// INSERT DATA REGISTER
Route::post('/auth/register', [UserController::class, 'userRegisterAuth']);

// LOGIN VIEW
Route::get('/login', [UserController::class, 'viewUserLogin']);
// INSERT DATA LOGIN
Route::post('/auth/login', [UserController::class, 'userLoginAuth']);

