<?php

/**
 * Events
 */
Event::listen('Nook.Registration.Events.UserRegistered', function()
{

});

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
Route::get('statuses', 'StatusController@index');