<?php

$I = new FunctionalTester($scenario);
$I->am('Nook member');
$I->wantTo('list all users who are registered for Nook');

$I->haveAnAccount(['username' => 'ClarkKent']);
$I->haveAnAccount(['username' => 'LexLuthor']);

$I->amOnPage('/users');
$I->see('ClarkKent');
$I->see('LexLuthor');