<?php

$I = new FunctionalTester($scenario);
$I->am('Nook member');
$I->wantTo('I want to view my profile.');

$I->signIn();
$I->postAStatus('My new status.');

$I->click('Your Profile');
$I->seeCurrentUrlEquals('/@ClarkKent');

$I->see('My new status.');