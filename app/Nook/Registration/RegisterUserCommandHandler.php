<?php namespace Nook\Registration;

use Laracasts\Commander\Events\DispatchableTrait;
use Nook\Users\User;
use Nook\Users\UserRepository;
use Laracasts\Commander\CommandHandler;

/**
 * Class RegisterUserCommandHandler
 *
 * @package Nook\Registration
 */
class RegisterUserCommandHandler implements CommandHandler
{
   use DispatchableTrait;

   /**
    * @var UserRepository
    */
   protected $userRepository;

   public function __construct(UserRepository $userRepository)
   {
      $this->userRepository = $userRepository;
   }
   /**
    * Handle the command
    *
    * @param $command
    * @return mixed
    */
   public function handle($command)
   {
      // Register the user
      $user = User::register(
         $command->username,
         $command->email,
         $command->password
      );

      // Persist the user
      $this->userRepository->save($user);

      // Release the events
      $this->dispatchEventsFor($user);

      return $user;
   }
}