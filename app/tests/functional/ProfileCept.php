<?php

$I = new FunctionalTester($scenario);
$I->am('Nook member');
$I->wantTo('I want to view my profile.');

$I->signIn();
$I->postAStatus('my new status.');

$I->click('ClarkKent');
$I->seeCurrentUrlEquals('/@ClarkKent');

$I->see('my new status.');