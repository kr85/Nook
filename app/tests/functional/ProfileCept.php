<?php

$I = new FunctionalTester($scenario);
$I->am('Nook member');
$I->wantTo('I want to view my profile.');

$I->signIn();
$I->postAStatus('my new status.');

$I->click('Your Profile');
$I->seeCurrentUrlEquals('/@clarkkent');

$I->see('my new status.');