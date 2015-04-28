<?php

use Nook\Statuses\StatusRepository;
use Laracasts\TestDummy\Factory as TestDummy;

/**
 * Class StatusRepositoryTest
 */
class StatusRepositoryTest extends \Codeception\TestCase\Test
{
    /**
     * @var \IntegrationTester
     */
    protected $tester;

    /**
     * @var StatusRepository
     */
    protected $repository;

    /**
     * Setup before tests.
     */
    protected function _before()
    {
        $this->repository = new StatusRepository;
    }

    /** @test */
    public function it_gets_all_statuses_for_a_user()
    {
        // Given I have two users
        $users = TestDummy::times(2)->create('Nook\Users\User');

        // And statuses for both of them
        TestDummy::times(2)->create('Nook\Statuses\Status', [
            'user_id' => $users[0]->id,
            'body' => 'My status'
        ]);

        TestDummy::times(2)->create('Nook\Statuses\Status', [
            'user_id' => $users[1]->id,
            'body' => 'His status'
        ]);

        // When I fetch statuses for one user
        $statusesForUser = $this->repository->getAllForUser($users[0]);

        // Then I should receive only the relevant ones
        $this->assertCount(2, $statusesForUser);
        $this->assertEquals('My status', $statusesForUser[0]->body);
        $this->assertEquals('My status', $statusesForUser[1]->body);
    }

    /** @test */
    public function it_saves_a_status_for_a_user()
    {
        // And an existing user
        $user = TestDummy::create('Nook\Users\User');

        // Given I have an unsaved status
        $status = TestDummy::create('Nook\Statuses\Status', [
            'user_id' => $user->id,
            'body' => 'My status'
        ]);

        // When I try to persist this status
        $savedStatus = $this->repository->save($status, $user->id);

        // Then it should be saved
        $this->tester->seeRecord('statuses', [
            'body' => 'My status'
        ]);

        // And the status should have the correct user id
        $this->assertEquals($user->id, $savedStatus->user_id);
    }
}