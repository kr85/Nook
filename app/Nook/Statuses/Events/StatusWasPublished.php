<?php namespace Nook\Statuses\Events;

/**
 * Class StatusWasPublished
 *
 * @package Nook\Statuses\Events
 */
class StatusWasPublished 
{
   /**
    * @var $status
    */
   public $status;

   /**
    * Constructor.
    *
    * @param $status
    */
   public function __construct($status)
   {
      $this->status = $status;
   }
}