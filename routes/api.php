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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/leaderboard', 'UserController@getAllUsers');
Route::post('/create', 'UserController@createUser');
Route::get('/update-points/{id}/{modifier}', 'UserController@updatePoints');
Route::get('/get-user/{id}', 'UserController@getUser');
Route::delete('/delete-user/{id}', 'UserController@deleteUser');


Route::prefix('user')->group(function () {
    Route::namespace('User')->group(function () {
        // Controllers Within The "App\Http\Controllers\User" Namespace
        Route::post('login', 'UserController@login');
        Route::post('authenticate', 'DashboardLoginController@authenticate');
        Route::post('register', 'UserController@register');
    });
});
