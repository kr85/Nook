<?php namespace Nook\Core;

use App;

/**
 * Class CommandBus
 *
 * @package Nook\Core
 */
trait CommandBus
{
   /**
    * Execute the command.
    *
    * @param $command
    * @return mixed
    */
   public function execute($command)
   {
      return $this->getCommandBus()->execute($command);
   }

   /**
    * Fetch the command bus.
    *
    * @return mixed
    */
   public function getCommandBus()
   {
      return App::make('Laracasts\Commander\CommandBus');
   }
}