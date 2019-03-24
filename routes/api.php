<?php

use Illuminate\Support\Facades\Route;

// AUTH endpoints
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth',
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');

    Route::group(['middleware' => 'jwt'], function () {
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('me', 'AuthController@me');
        Route::post('payload', 'AuthController@payLoad');
    });
});

// Logged users
Route::group(['middleware' => 'jwt'], function () {
    // USER endpoints
    Route::resource('users', 'UserController');
    Route::get('users/show-auth', 'UserController@showAuth');

    // TASK endpoints
    Route::resource('tasks', 'TaskController');
    Route::get('task-user', 'TaskUserController@index');
    Route::get('task-user/{task_id}/users', 'TaskUserController@getUsers');
    Route::patch('task-user/{task_id}', 'TaskUserController@update');
    Route::delete('task-user/{task_id}', 'TaskUserController@destroy');
});
