<?php namespace Nook\Statuses;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

/**
 * Class UpdateStatusCommandHandler
 *
 * @package Nook\Statuses
 */
class UpdateStatusCommandHandler implements CommandHandler
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
        // Update the status
        $this->statusRepository->update($command->statusId, ['body' => trim($command->body)]);

        // Find the updated status
        $status = Status::findOrFail($command->statusId);

        // Dispatch an event
        $this->dispatchEventsFor($status);

        return $status;
    }
}