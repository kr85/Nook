<?php

$I = new FunctionalTester($scenario);
$I->am('guest');
$I->wantTo('sign up for Nook account');

$I->amOnPage('/');
$I->click('Sign Up!');
$I->seeCurrentUrlEquals('/register');

$I->fillField('Username:', 'ClarkKent');
$I->fillField('Email:', 'clark@example.com');
$I->fillField('Password:', 'demo');
$I->fillField('Password Confirmation:', 'demo');
$I->click('Sign Up');

$I->seeCurrentUrlEquals('');
$I->see('Welcome to Nook!');
$I->seeRecord('users', [
   'username' => 'ClarkKent',
   'email'    => 'clark@example.com'
]);

$I->assertTrue(Auth::check());