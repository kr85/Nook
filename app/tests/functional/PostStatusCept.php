<?php

$I = new FunctionalTester($scenario);
$I->am('Nook member');
$I->wantTo('I want to post a status to my profile.');

$I->signIn();

$I->amOnPage('statuses');

$I->postAStatus('My first status!');

$I->seeCurrentUrlEquals('/statuses');
$I->see('My first status!');