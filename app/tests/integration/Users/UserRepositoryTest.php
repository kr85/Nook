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

    /** @test */
    public function it_finds_a_user_by_id()
    {
        $users = TestDummy::times(2)->create('Nook\Users\User');

        $user = $this->repository->findById($users[0]->id);

        $this->assertEquals($user->id, $users[0]->id);
    }

    /** @test */
    public function it_follows_another_user()
    {
        // Creates two dummy users
        list($clark, $lex) = TestDummy::times(2)->create('Nook\Users\User');

        // and $clark follows $lex
        $this->repository->follow($lex->id, $clark);

        // Check follows table for follower_id and followed_id
        $this->tester->seeRecord('follows',[
            'follower_id' => $clark->id,
            'followed_id' => $lex->id
        ]);
    }

    /** @test */
    public function it_unfollows_another_user()
    {
        // Creates two dummy users
        list($clark, $lex) = TestDummy::times(2)->create('Nook\Users\User');

        // and $clark follows $lex
        $this->repository->follow($lex->id, $clark);

        // When $clark unfollows $lex
        $this->repository->unfollow($lex->id, $clark);

        // Check follows table for follower_id and followed_id
        $this->tester->dontSeeRecord('follows',[
            'follower_id' => $clark->id,
            'followed_id' => $lex->id
        ]);
    }
}