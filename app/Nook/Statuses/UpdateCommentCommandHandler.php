<?php namespace Nook\Statuses;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

/**
 * Class UpdateCommentCommandHandler
 *
 * @package Nook\Statuses
 */
class UpdateCommentCommandHandler implements CommandHandler
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
        // Update the comment
        $this->statusRepository->updateComment($command->comment_id, ['body' => trim($command->body)]);

        // Find the updated comment
        $comment = Comment::find($command->comment_id);

        return $comment;
    }
}