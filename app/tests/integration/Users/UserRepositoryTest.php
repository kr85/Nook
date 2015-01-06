<?php

use Nook\Users\UserRepository;
use Laracasts\TestDummy\Factory as TestDummy;

/**
 * Class UserRepositoryTest
 */
class UserRepositoryTest extends \Codeception\TestCase\Test
{
    /**
     * @var \IntegrationTester
     */
    protected $tester;

    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * Setup before tests.
     */
    protected function _before()
    {
        $this->repository = new UserRepository;
    }

    /** @test */
    public function it_paginates_all_users()
    {
        TestDummy::times(4)->create('Nook\Users\User');

        $results = $this->repository->getPaginated(2);

        $this->assertCount(2, $results);
    }

    /** @test */
    public function it_finds_a_user_with_statuses_by_username()
    {
        $statuses = TestDummy::times(3)->create('Nook\Statuses\Status');
        $username = $statuses[0]->user->username;

        $user = $this->repository->findByUsername($username);

        $this->assertEquals($username, $user->username);
        $this->assertCount(3, $user->statuses);
    }
}