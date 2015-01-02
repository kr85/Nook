<?php
namespace Codeception\Module;

use Laracasts\TestDummy\Factory as TestDummy;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class FunctionalHelper extends \Codeception\Module
{
   public function signIn()
   {
      $email = 'demo@email.com';
      $password = 'demo';

      $this->haveAnAccount(compact('email', 'password'));

      $I = $this->getModule('Laravel4');

      $I->amOnPage('/login');
      $I->fillField('email', $email);
      $I->fillField('password', $password);
      $I->click('Sign In');
   }

   public function haveAnAccount($overrides = [])
   {
      TestDummy::create('Nook\Users\User', $overrides);
   }
}
