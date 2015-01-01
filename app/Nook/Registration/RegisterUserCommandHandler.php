<?php namespace Nook\Registration;

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
      $user = User::register(
         $command->username,
         $command->email,
         $command->password
      );

      $this->userRepository->save($user);
      return $user;
   }
}