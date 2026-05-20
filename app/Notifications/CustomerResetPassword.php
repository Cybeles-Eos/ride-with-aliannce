<?php

namespace App\Notifications;

use App\Http\Traits\SystemSettingTrait;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

/**
 * Class CustomerResetPassword
 * @package App\Notifications
 */
class CustomerResetPassword extends Notification
{
    use SystemSettingTrait;

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * The user object.
     *
     * @var string
     */
    public $user;

    /**
     * Create a new notification instance.
     *
     * @param $token
     * @param $user
     */
    public function __construct($token, $user)
    {
        $this->token = $token;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $user = $this->user;
        $token = $this->token;
        $url = url('customer/password/reset/' . $token);
        $mail_segments = explode("@", $user->email);
        $trimmed_email[0] = $this->asterisk($mail_segments[0]);
        $trimmed_email[1] = $this->asterisk($mail_segments[1]);
        $trimmed_email = implode("@", $trimmed_email);
        $system_setting_name = $this->getSystemSettingByCode('SS0001');
        $system_setting_email = $this->getSystemSettingByCode('SS0002');

        return (new MailMessage)
            ->view('email.password', [
                    'email' => $trimmed_email,
                    'url' => $url,
                ]
            )
            ->bcc(config('constants.dnr_bcc'))
            ->subject('Customer Reset Password')
            ->from($system_setting_email->value, $system_setting_name->value)/*
            ->to($user->email)*/;
    }

    /**
     * Trim string passed with '*'
     *
     * @param $string
     *
     * @return string
     */
    protected function asterisk($string)
    {
        $length = strlen($string);
        $trimmed = $string;
        if ($length > 1) {
            if ($length == 2) {
                $trimmed = substr($string, 0, 1) . str_repeat('*', $length- 1);
            } else if ($length >= 3) {
                $trimmed = substr($string, 0, 1) . str_repeat('*', $length - 2) . substr($string, $length - 1);
            }
        }
        return $trimmed;
    }
}
