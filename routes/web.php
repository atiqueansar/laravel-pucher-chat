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

Route::view('/signup', 'signup')->name('signup');
Route::view('/login', 'login')->name('login');
Route::post('/check-email', 'AuthController@checkEmail')->name('check-email');
Route::post('/login-user', 'AuthController@loginUser')->name('login-user');
Route::post('/signup-user', 'AuthController@signupUser')->name('signup-user');

Route::middleware(['patient_auth'])->group(function () {
    Route::get('/', 'MessageController@index')->name('dashboard');
    Route::get('/get-messages/{receiverId}', 'MessageController@getMessage')->name('get-messages');
    Route::post('/send-message/{receiverId}', 'MessageController@sendMessage')->name('send-message');
    Route::get('/logout', 'AuthController@logout')->name('logout');
});
