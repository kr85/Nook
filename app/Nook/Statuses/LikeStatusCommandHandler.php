<?php namespace Nook\Statuses;

use Laracasts\Commander\CommandHandler;

/**
 * Class LikeStatusCommandHandler
 *
 * @package Nook\Statuses
 */
class LikeStatusCommandHandler implements CommandHandler
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
     * @return static
     */
    public function handle($command)
    {
        // Store in local variables userId and statusId
        $userId = $command->user_id;
        $statusId = $command->status_id;
        // Result variable
        $result = [];
        $result['success'] = false;
        $result['message'] = 'There was a problem.';
        $result['liked'] = false;

        // Check if the status was already liked
        $liked = $this->statusRepository->statusLiked($userId, $statusId);
        if (isset($liked))
        {
            // Unliked the status
            $this->statusRepository->unlikeStatus($liked->id);
            $result['success'] = true;
            $result['message'] = 'You unliked this status.';
            $result['liked'] = false;

        } else {
            // Like the status
            $this->statusRepository->likeStatus($command->user_id, $command->status_id);
            $result['success'] = true;
            $result['message'] = 'You liked this status.';
            $result['liked'] = true;
        }

        return $result;
    }
}