<?php namespace Nook\Registration;

/**
 * Class RegisterUserCommand
 *
 * @package Nook\Registration
 */
class RegisterUserCommand
{
   /**
    * @var $username
    */
   public  $username;

   /**
    * @var $email
    */
   public $email;

   /**
    * @var $password
    */
   public $password;

   /**
    * Constructor.
    *
    * @param $username
    * @param $email
    * @param $password
    */
   function __construct($username, $email, $password)
   {
      $this->username = $username;
      $this->email    = $email;
      $this->password = $password;
   }


}