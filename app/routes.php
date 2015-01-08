<?php

Route::get('/', [
   'as'   => 'home',
   'uses' => 'PagesController@home'
]);

/**
 * Registration
 */
Route::get('register', [
   'as'   => 'register_route',
   'uses' => 'RegistrationController@create'
]);

Route::post('register', [
   'as'   => 'register_route',
   'uses' => 'RegistrationController@store'
]);

/**
 * Sessions
 */
Route::get('login', [
   'as'   => 'login_route',
   'uses' => 'SessionsController@create'
]);

Route::post('login', [
   'as'   => 'login_route',
   'uses' => 'SessionsController@store'
]);

Route::get('logout', [
   'as'   => 'logout_route',
   'uses' => 'SessionsController@destroy'
]);

/**
 * Statuses
 */
Route::get('statuses', [
   'as'   => 'statuses_route',
   'uses' => 'StatusesController@index'
]);

Route::post('statuses', [
   'as'   => 'statuses_route',
   'uses' => 'StatusesController@store'
]);

/**
 * Users
 */
Route::get('users', [
    'as'   => 'users_route',
    'uses' => 'UsersController@index'
]);

Route::get('@{username}', [
    'as'   => 'profile_route',
    'uses' => 'UsersController@show'
]);

/**
 * Follows
 */
Route::post('followers', [
    'as'   => 'followers_route',
    'uses' => 'FollowsController@store'
]);

Route::delete('follow/{id}', [
    'as'   => 'follow_route',
    'uses' => 'FollowsController@destroy'
]);

/**
 * Password Resets
 */
Route::get('remind', [
    'as'   => 'password_remind',
    'uses' => 'RemindersController@getRemind'
]);

Route::post('remind', [
    'as'   => 'password_remind',
    'uses' => 'RemindersController@postRemind'
]);

Route::get('reset/{token}', [
    'as'   => 'password_reset',
    'uses' => 'RemindersController@getReset'
]);

Route::post('reset', [
    'as'   => 'password_reset',
    'uses' => 'RemindersController@postReset'
]);
