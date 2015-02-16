<?php namespace Nook\Statuses;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

/**
 * Class PublishStatusCommandHandler
 *
 * @package Nook\Statuses
 */
class PublishStatusCommandHandler implements CommandHandler
{
    use DispatchableTrait;

    /**
     * @var StatusRepository
     */
    protected $statusRepository;

    /**
     * Constructor.
     *
     * @param StatusRepository $statusRepository
     */
    public function __construct(StatusRepository $statusRepository)
    {
        $this->statusRepository = $statusRepository;
    }

    /**
     * Handle the command.
     *
     * @param $command
     * @return mixed
     */
    public function handle($command)
    {
        // Setup the status and fires an event
        $status = Status::publish(trim($command->body));

        // Persists the status
        $status = $this->statusRepository->save($status, $command->userId);

        // Dispatch an event
        $this->dispatchEventsFor($status);

        return $status;
    }
}