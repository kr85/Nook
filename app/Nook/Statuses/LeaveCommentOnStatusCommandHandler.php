<?php namespace Nook\Statuses;

use Laracasts\Commander\CommandHandler;

/**
 * Class LeaveCommentOnStatusCommandHandler
 *
 * @package Nook\Statuses
 */
class LeaveCommentOnStatusCommandHandler implements CommandHandler
{
    protected $statusRepository;

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
        $comment = $this->statusRepository->leaveComment($command->user_id, $command->status_id, trim($command->body));

        return $comment;
    }

}