<?php namespace Nook\Users;

use Laracasts\Commander\CommandHandler;

/**
 * Class UnfollowUserCommandHandler
 *
 * @package Nook\Users
 */
class UnfollowUserCommandHandler implements CommandHandler
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * Constructor.
     *
     * @param UserRepository $userRepository
     */
    function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Handle the command.
     *
     * @param object $command
     * @return void
     */
    public function handle($command)
    {
        $user = $this->userRepository->findById($command->userId);

        $this->userRepository->unfollow($command->userIdToUnfollow, $user);
    }

}