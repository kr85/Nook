<?php namespace Nook\Statuses;

use Laracasts\Commander\CommandHandler;

/**
 * Class DeleteStatusCommandHandler
 *
 * @package Nook\Statuses
 */
class DeleteStatusCommandHandler implements CommandHandler
{
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
     * @param object $command
     * @return void
     */
    public function handle($command)
    {
        $status = $this->statusRepository->findById($command->status_id);

        $this->statusRepository->delete($status->id);
    }
}