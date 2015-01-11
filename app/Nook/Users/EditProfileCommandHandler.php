<?php namespace Nook\Users;

use Laracasts\Commander\CommandHandler;

/**
 * Class EditProfileCommandHandler
 *
 * @package Nook\Users
 */
class EditProfileCommandHandler implements CommandHandler
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
    public function __construct(UserRepository $userRepository)
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
        $input = [
            'userIdToUpdate' => $command->userIdToUpdate,
            'username' => $command->username,
            'email' => $command->email,
            'password' => $command->password
        ];

        return $this->userRepository->updateProfile($input);
    }

}