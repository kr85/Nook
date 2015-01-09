<?php

$I = new FunctionalTester($scenario);
$I->am('guest');
$I->wantTo('sign up for Nook account');

$I->amOnPage('/');

$I->submitForm('#registration_form', ['username' => 'ClarkKent', 'email' => 'clark@example.com', 'password' => 'secret', 'password_confirmation' => 'secret'], 'Sign Up');

$I->seeCurrentUrlEquals('');
$I->see('Welcome to Nook!');
$I->seeRecord('users', [
   'username' => 'ClarkKent',
   'email'    => 'clark@example.com'
]);

$I->assertTrue(Auth::check());