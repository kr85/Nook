<?php namespace Nook\Statuses;

class PublishStatusCommand 
{
   /**
    * @var $body
    */
   public $body;

   /**
    * @var $userId
    */
   public $userId;

   /**
    * Constructor.
    *
    * @param $body
    * @param $userId
    */
   function __construct($body, $userId)
   {
      $this->body = $body;
      $this->userId = $userId;
   }
}