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
        Route::post('authenticate', 'UserController@authenticate');
    });
});

Route::middleware('ApiAuthenticator')->group(function () {
    Route::prefix('record')->group(function () {
        Route::namespace('Records')->group(function () {
            Route::post('create', 'RecordController@create');
            Route::get('get', 'RecordController@get');
            Route::post('update', 'RecordController@update');
        });
    });

    Route::prefix('item')->group(function () {
        Route::namespace('Items')->group(function () {
            Route::post('create', 'ItemController@create');
            Route::get('get', 'ItemController@get');
            Route::post('update', 'ItemController@update');
            Route::post('delete', 'ItemController@delete');
        });
    });

    Route::prefix('commission')->group(function () {
        Route::namespace('Commission')->group(function () {
            Route::post('create', 'CommissionController@create');
            Route::get('get', 'CommissionController@get');
            Route::post('update', 'CommissionController@update');
            Route::post('delete', 'CommissionController@delete');
        });
    });

    Route::prefix('user')->group(function () {
        Route::namespace('User')->group(function () {
            // Controllers Within The "App\Http\Controllers\User" Namespace
            Route::get('get-users', 'UserController@getUsers');
            Route::post('register', 'UserController@register');
            Route::post('delete', 'UserController@delete');
            Route::post('update', 'UserController@update');
        });
    });
});
