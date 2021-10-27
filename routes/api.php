<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('login', 'ApiController@authenticate');
Route::post('/pw/email', 'AuthenticationController@sendResetLinkEmail');
Route::post('/pw/reset', 'AuthenticationController@resetPassword');
Route::post('admin-register', 'Api\UserController@adminRegister');
Route::post('setUserPicture', 'Api\UserController@setUserProfilePicture');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); 

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::post('register', 'Api\UserController@store');
    Route::get('getusers', 'Api\UserController@getUserDetails');
    Route::get('user/{id}', 'Api\UserController@getUser');
    Route::put('update-user/{id}', 'Api\UserController@updateUser');
    Route::delete('delete-user/{id}', 'Api\UserController@deleteUser');
    Route::get('getrelations', 'Api\UserController@getRelations');
    Route::get('getbloodgroup', 'Api\UserController@getBloodGroup');
    Route::put('edit-access/{id}', 'Api\UserController@editAccess');
});