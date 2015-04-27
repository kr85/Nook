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
     * @param $command
     * @return \Illuminate\Support\Collection|UserRepository|static
     */
    public function handle($command)
    {
        $input = [
            'userIdToUpdate' => $command->userIdToUpdate,
            'username' => trim($command->username),
            'email' => trim($command->email),
            'password' => $command->password
        ];

        return $this->userRepository->updateProfile($input);
    }

}