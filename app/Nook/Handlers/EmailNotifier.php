<?php namespace Nook\Handlers;

use Laracasts\Commander\Events\EventListener;
use Nook\Mailers\UserMailer;
use Nook\Registration\Events\UserHasRegistered;

/**
 * Class EmailNotifier
 *
 * @package Nook\Handlers
 */
class EmailNotifier extends EventListener
{
    /**
     * @var UserMailer
     */
    protected $mailer;

    /**
     * Constructor.
     *
     * @param UserMailer $mailer
     */
    public function __construct(UserMailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Send a welcome message when a new user has registered.
     *
     * @param UserHasRegistered $event
     */
    public function whenUserHasRegistered(UserHasRegistered $event)
    {
        $this->mailer->sendWelcomeMessageTo($event->user);
    }
}