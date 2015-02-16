<?php namespace Nook\Mailers;

use Nook\Users\User;

/**
 * Class UserMailer
 *
 * @package Nook\Mailers
 */
class UserMailer extends Mailer
{
    /**
     * Send a welcome message to a new user.
     *
     * @param User $user
     */
    public function sendWelcomeMessageTo(User $user)
    {
        $subject = 'Welcome to Nook!';
        $view = 'emails.registration.confirm';
        $data = [];

        return $this->sendTo($user, $subject, $view);
    }
}