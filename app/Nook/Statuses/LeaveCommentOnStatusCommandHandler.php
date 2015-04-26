<?php namespace Nook\Statuses;

use Laracasts\Commander\CommandHandler;

/**
 * Class LeaveCommentOnStatusCommandHandler
 *
 * @package Nook\Statuses
 */
class LeaveCommentOnStatusCommandHandler implements CommandHandler
{

    /**
     * @var StatusRepository $statusRepository
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
     * @return static
     */
    public function handle($command)
    {
        $comment = $this->statusRepository->leaveComment($command->user_id, $command->status_id, trim($command->body));

        return $comment;
    }

}