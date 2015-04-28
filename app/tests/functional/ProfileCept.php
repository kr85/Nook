<?php

$I = new FunctionalTester($scenario);
$I->am('Nook member');
$I->wantTo('I want to view my profile.');

$I->signIn();
$I->postAStatus('my new status.');

$I->amOnPage('statuses');

$I->click('ClarkKent');
$I->amOnPage('@ClarkKent');
$I->seeCurrentUrlEquals('/@ClarkKent');

$I->see('my new status.');