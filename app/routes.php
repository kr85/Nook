<?php

/*
 * Events
 */
Event::listen('Nook.Registration.Events.UserRegistered', function()
{

});

Route::get('/', [
   'as'   => 'home',
   'uses' => 'PagesController@home'
]);

/*
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