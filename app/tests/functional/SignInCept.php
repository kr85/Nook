<?php

$I = new FunctionalTester($scenario);
$I->am('Nook member');
$I->wantTo('login to my Nook account');

$I->signIn();

$I->seeInCurrentUrl('/statuses');
$I->see('Welcome back!');
$I->assertTrue(Auth::check());