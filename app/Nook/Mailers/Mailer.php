<?php namespace Nook\Mailers;

use Illuminate\Mail\Mailer as Mail;

/**
 * Class Mailer
 *
 * @package Nook\Mailers
 */
abstract class Mailer
{
    /**
     * @var Mail
     */
    protected $mail;

    /**
     * Constructor.
     *
     * @param Mail $mail
     */
    public function __construct(Mail $mail)
    {
        $this->mail = $mail;
    }

    /**
     * Send email to user.
     *
     * @param $user
     * @param $subject
     * @param $view
     * @param $data
     */
    public function sendTo($user, $subject, $view, $data = [])
    {
        $this->mail->queue($view, $data, function($message) use($user, $subject)
        {
            $message->to($user->email)->subject($subject);
        });
    }
}