<?php

$I = new FunctionalTester($scenario);
$I->am('Nook member.');
$I->wantTo('follow other Nook members.');

$I->haveAnAccount(['username' => 'OtherUser']);
$I->signIn();

$I->amOnPage('users');
$I->click('OtherUser');

$I->seeCurrentUrlEquals('/@OtherUser');

// When I follow a user
$I->click('Follow OtherUser');
$I->seeCurrentUrlEquals('/@OtherUser');
$I->see('Unfollow OtherUser');

// When I unfollow a user
$I->click('Unfollow OtherUser');
$I->seeCurrentUrlEquals('/@OtherUser');
$I->see('Follow OtherUser');

