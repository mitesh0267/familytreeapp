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

Route::get('login','Admin\LoginController@index')->name('login');
Route::post('login','Admin\LoginController@checkLogin')->name('login.check-login');
Route::get('register','Admin\RegistrationController@index')->name('register');
Route::post('register','Admin\RegistrationController@store')->name('register.store');

// Forgot Password
Route::get('forgot-password/', 'Admin\ForgotPasswordController@index')->name('forgot-password.index');
Route::get('forgot-password/{email}/{token}', 'Admin\ForgotPasswordController@showResetPasswordForm')->name('forgot-password.reset');
Route::post('forgot-password/email', 'Admin\ForgotPasswordController@email')->name('forgot-password.email');
Route::post('forgot-password/reset-password', 'Admin\ForgotPasswordController@resetPassword')->name('forgot-password.reset-password');
	

Route::middleware('auth')->namespace('Admin')->group(function(){

	Route::get('home','HomeController@index')->name('home');

	Route::resource('profile', 'ProfileController');
    Route::post('profile/change-password', 'ProfileController@changePassword')->name('profile.change-password');

    Route::post('user/get-all', 'UserController@getAll')->name('user.get-all');
	Route::get('user/status/{id}', 'UserController@updateStatus')->name('user.status');
	Route::get('user/edit-to-access/{id}', 'UserController@updateEditToAccess')->name('user.edit_to_access');
    Route::resource('user', 'UserController');

	Route::get('/logout', function () {
		Auth::logout();
	    return redirect()->route('login');
	})->name('logout');
});

Route::get('clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    return "Cache is cleared";
});
