<?php namespace Codeception\Module;

use Laracasts\TestDummy\Factory as TestDummy;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class FunctionalHelper extends \Codeception\Module
{
    /**
     * Login a user.
     *
     * @throws \Codeception\Exception\Module
     */
    public function signIn()
    {
        $email = 'demo@email.com';
        $username = 'ClarkKent';
        $password = 'demo';

        $this->haveAnAccount(compact('email', 'username', 'password'));

        $I = $this->getModule('Laravel4');

        $I->amOnPage('/login');
        $I->fillField('email', $email);
        $I->fillField('password', $password);
        $I->click('Sign In');
    }

    /**
     * Post a status.
     *
     * @param $status
     * @throws \Codeception\Exception\Module
     */
    public function postAStatus($status)
    {
        $I = $this->getModule('Laravel4');

        $I->fillField('body', $status);
        $I->click('Post Status');
    }

    /**
     * Have an account.
     *
     * @param array $overrides
     * @return mixed
     */
    public function haveAnAccount($overrides = [])
    {
        return $this->have('Nook\Users\User', $overrides);
    }

    /**
     * Create a test dummy object.
     *
     * @param $model
     * @param array $overrides
     * @return mixed
     */
    public function have($model, $overrides = [])
    {
        return TestDummy::create($model, $overrides);
    }
}
