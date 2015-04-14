<?php


Route::get('/', [
    'as'   => 'home',
    'uses' => 'PagesController@home'
]);

/**
 * Registration
 */
Route::post('register', [
   'as'     => 'register_route',
   'uses'   => 'RegistrationController@store',
   'before' => 'guest'
]);

/**
 * Sessions
 */
Route::post('login', [
   'as'     => 'login_route',
   'uses'   => 'SessionsController@store',
   'before' => 'guest'
]);

Route::get('logout', [
   'as'   => 'logout_route',
   'uses' => 'SessionsController@destroy'
]);

/**
 * Statuses
 */
Route::get('statuses', [
   'as'     => 'statuses_route',
   'uses'   => 'StatusesController@index',
   'before' => 'auth'
]);

Route::post('statuses', [
   'as'     => 'statuses_route',
   'uses'   => 'StatusesController@store',
   'before' => 'csrf'
]);

Route::delete('statuses/{id}', [
    'as'   => 'delete_status_route',
    'uses' => 'StatusesController@destroy',
    'before' => 'csrf'
]);

Route::patch('statuses/{id}', [
    'as'     => 'update_status_route',
    'uses'   => 'StatusesController@update',
    'before' => 'csrf'
]);

Route::post('statuses/{id}/comments', [
    'as'     => 'comment_route',
    'uses'   => 'CommentsController@store',
    'before' => 'csrf'
]);

Route::post('statuses/{id}/hide', [
    'as'     => 'hide_status_route',
    'uses'   => 'StatusesController@hide',
    'before' => 'auth'
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

Route::get('users/{id}/edit', [
    'as'     => 'edit_profile_route',
    'uses'   => 'UsersController@edit',
    'before' => 'auth'
]);

Route::patch('users/{id}', [
    'as'     => 'update_profile_route',
    'uses'   => 'UsersController@update',
    'before' => 'csrf'
]);

/**
 * Follows
 */
Route::post('followers', [
    'as'     => 'followers_route',
    'uses'   => 'FollowsController@store',
    'before' => 'csrf'
]);

Route::delete('follow/{id}', [
    'as'   => 'follow_route',
    'uses' => 'FollowsController@destroy'
]);

/**
 * Password Resets
 */
Route::get('remind', [
    'as'     => 'password_remind',
    'uses'   => 'RemindersController@getRemind',
    'before' => 'guest'
]);

Route::post('remind', [
    'as'     => 'password_remind',
    'uses'   => 'RemindersController@postRemind',
    'before' => 'guest'
]);

Route::get('reset/{token}', [
    'as'     => 'password_reset',
    'uses'   => 'RemindersController@getReset',
    'before' => 'guest'
]);

Route::post('reset', [
    'as'     => 'password_reset',
    'uses'   => 'RemindersController@postReset',
    'before' => 'csrf'
]);
