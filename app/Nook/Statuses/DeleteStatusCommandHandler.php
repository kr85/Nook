<?php namespace Nook\Statuses;

use File;
use Nook\Helpers\Helper;
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
        // Find the status by id
        $status = $this->statusRepository->findById($command->status_id);

        // Check if the status has a file name in the database
        if ($status->image)
        {
            // Check if the image file exists
            while (File::exists(Helper::getStatusMediaPath($status->image)))
            {
                // Delete the image
                unlink(Helper::getStatusMediaPath($status->image));
            }
        }

        // Delete the record from the database
        $this->statusRepository->delete($status->id);
    }
}