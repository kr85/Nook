<?php

$I = new FunctionalTester($scenario);
$I->am('Nook member');
$I->wantTo('delete a status');

$I->signIn();

$I->amOnPage('statuses');

$I->postAStatus('The status I am going to delete.');

$I->amOnPage('statuses');

$I->seeCurrentUrlEquals('/statuses');
$I->see('The status I am going to delete.');
$I->seeRecord('statuses', [
    'body' => 'The status I am going to delete.'
]);

$I->click('Delete Status');

$I->see('Your status has been deleted.');

$I->dontSee('The status I am going to delete.');
$I->dontSeeRecord('statuses', [
    'body' => 'The status I am going to delete.'
]);