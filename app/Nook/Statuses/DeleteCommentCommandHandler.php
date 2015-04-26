<?php namespace Nook\Statuses;

use Laracasts\Commander\CommandHandler;

class DeleteCommentCommandHandler implements CommandHandler
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
        // Find the comment by id
        $comment = $this->statusRepository->findCommentById($command->comment_id);

        // Delete the record from the database
        $this->statusRepository->deleteComment($comment->id);
    }
}