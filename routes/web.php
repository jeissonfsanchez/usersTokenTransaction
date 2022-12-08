<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Redirect;
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

/* Punto 8 */

Route::get('/users/{token}',[UserController::class,'getUsers']);

Route::get('/users/{token}/transaction/{client_id}',[UserController::class,'getUserTransaction'])->name('users.show');
