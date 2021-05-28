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
Route::get('/', 'AuthController@index')->name('login');
Route::post('login', 'AuthController@authenticate')->name('login.auth');
Route::post('logout', 'AuthController@logout')->name('logout');
Route::middleware('auth')->group(function(){
    Route::get('dashboard','DashboardController@index')->name('dashboard');
    Route::resource('user', 'UserController');
    Route::get('user/{id}/password', 'UserController@password')->name('user.password');
    Route::put('user/password/{id}', 'UserController@changePassword')->name('user.change.password');
});
