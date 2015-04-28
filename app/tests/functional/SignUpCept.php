<?php

$I = new FunctionalTester($scenario);
$I->am('guest');
$I->wantTo('sign up for Nook account');

$I->amOnPage('/');

$I->submitForm('#registration_form', ['username' => 'clarkkent', 'email' => 'clark@example.com', 'password' => 'secret', 'password_confirmation' => 'secret'], 'Sign Up');

$I->seeCurrentUrlEquals('/statuses');
$I->see("You haven't posted a status yet.");
$I->seeRecord('users', [
   'username' => 'clarkkent',
   'email'    => 'clark@example.com'
]);

$I->assertTrue(Auth::check());