<?php namespace Nook\Users;

use Laracasts\Presenter\Presenter;

/**
 * Class UserPresenter
 */
class UserPresenter extends Presenter
{
    /**
     * Present a link to the user's avatar.
     *
     * @param int $size
     * @return string
     */
    public function gravatar($size = 30)
    {
        $email = md5($this->email);

        return "//www.gravatar.com/avatar/{$email}?s={$size}";
    }

    /**
     * Present the number of followers the user has.
     *
     * @return string
     */
    public function followerCount()
    {
        $count = $this->entity->followers()->count();
        $plural = str_plural('Follower', $count);

        return "{$count} {$plural}";
    }

    /**
     * Present the number of statuses the user has.
     *
     * @return string
     */
    public function statusCount()
    {
        $count = $this->entity->statuses()->count();
        $plural = str_plural('Status', $count);

        return "{$count} {$plural}";
    }
}