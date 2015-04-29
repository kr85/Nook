<?php namespace Nook\Statuses;

use Laracasts\Presenter\Presenter;

/**
 * Class StatusPresenter
 *
 * @package Nook\Statuses
 */
class StatusPresenter extends Presenter
{
    /**
     * Display how long it has been since the status was published.
     *
     * @return mixed
     */
    public function timeSincePublished()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Get status likes owners' id and username.
     *
     * @return array
     */
    public function liked()
    {
        $liked = [];

        foreach ($this->likes as $like)
        {
            $liked[$like->owner->id] = $like->owner->username;
        }

        return $liked;
    }

    /**
     * Display the names of the users who liked the status.
     *
     * @return null|string
     */
    public function displayLikesOwners()
    {
        $owners = array_reverse($this->liked());
        $count = count($owners);
        $result = null;

        if ($count > 0)
        {
            if ($count == 1)
            {
                $ownerLinks  = $this->ownerLikeHref($owners);
                $result     .= implode($ownerLinks);
                $result     .= '</a> likes this.';
            }
            elseif ($count > 1 && $count <= 3)
            {
                $ownerLinks = $this->ownerLikeHref($owners);
                $lastItem   = array_pop($ownerLinks);
                $text       = implode(', ', $ownerLinks);
                $text      .= ' and '.$lastItem;
                $result     = $text.' like this.';
            }
            else
            {
                $owners     = array_slice($owners, 0, 3);
                $ownerLinks = $this->ownerLikeHref($owners);
                $text       = implode(', ', $ownerLinks);
                $text      .= ' and '.($count - 3);
                $result     = $text.' others like this.';
            }

            return $result;
        }

        return null;
    }

    /**
     * Get links for the profiles of the users who liked the status.
     *
     * @param $owners
     * @return array
     */
    private function ownerLikeHref($owners)
    {
        return array_map(function ($owner)
        {
            return sprintf('<a href="@'.$owner.'">'.str_limit($owner, 15).'</a>');
        }, $owners);
    }

    /**
     * Check if the current user liked the status.
     *
     * @param $userId
     * @return bool
     */
    public function didLike($userId)
    {
        $statusLikes = $this->liked();
        return array_key_exists($userId, $statusLikes);
    }
}