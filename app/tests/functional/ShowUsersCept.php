<?php

$I = new FunctionalTester($scenario);
$I->am('Nook member');
$I->wantTo('list all users who are registered for Nook');

$I->signIn();

$I->haveAnAccount(['username' => 'loislane']);
$I->haveAnAccount(['username' => 'lexluthor']);

$I->amOnPage('users');
$I->see('loislane');
$I->see('lexluthor');