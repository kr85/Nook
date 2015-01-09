<?php

$I = new FunctionalTester($scenario);
$I->am('Nook member');
$I->wantTo('list all users who are registered for Nook');

$I->haveAnAccount(['username' => 'clarkkent']);
$I->haveAnAccount(['username' => 'lexluthor']);

$I->amOnPage('/users');
$I->see('clarkkent');
$I->see('lexluthor');