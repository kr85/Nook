<?php

$I = new FunctionalTester($scenario);
$I->am('Nook member.');
$I->wantTo('follow other Nook members.');

$I->haveAnAccount(['username' => 'otheruser']);
$I->signIn();

$I->click('Browse Users');
$I->click('otheruser');

$I->seeCurrentUrlEquals('/@otheruser');

// When I follow a user
$I->click('Follow otheruser');
$I->seeCurrentUrlEquals('/@otheruser');
$I->see('Unfollow otheruser');

// When I unfollow a user
$I->click('Unfollow otheruser');
$I->seeCurrentUrlEquals('/@otheruser');
$I->see('Follow otheruser');

