<?php

namespace abenevaut\Laravel\EmailReset\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Auth\Authenticatable;
use abenevaut\Laravel\EmailReset\Config;

class EmailResetNotification extends Notification
{
    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * @var Authenticatable
     */
    public $user;

    /**
     * The callback that should be used to build the mail message.
     *
     * @var \Closure|null
     */
    public static $toMailCallback;


    /**
     * EmailResetNotification constructor.
     *
     * @param string $token
     * @param Authenticatable $user
     */
    public function __construct(string $token, Authenticatable $user)
    {
        $this->token = $token;
        $this->user  = $user;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed $notifiable
     *
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $resetLink = route('email-reset', $this->token);

        if (static::$toMailCallback) {
            return \call_user_func(static::$toMailCallback, $notifiable, $this->token, $resetLink);
        }

        $translationParameters = [
            'user_name' => $notifiable->name,
            'old_email' => $notifiable->email,
            'new_email' => $notifiable->new_email,
        ];

        return (new MailMessage())
            ->line(trans('notification_line1', $translationParameters))
            ->action(trans('notification_button', $translationParameters), $resetLink)
            ->line(trans('notification_line2', $translationParameters));
    }

    /**
     * Set a callback that should be used when building the notification mail message.
     *
     * @param  callable $callback
     *
     * @return void
     */
    public static function toMailUsing($callback)
    {
        static::$toMailCallback = $callback;
    }
}
