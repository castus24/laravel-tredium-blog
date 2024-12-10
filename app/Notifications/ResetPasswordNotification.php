<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\HtmlString;

class ResetPasswordNotification extends ResetPassword
{
    /**
     * Get the reset password notification mail message for the given URL.
     *
     * @param $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting(
                new HtmlString(
                    '<div class="greeting">' . Lang::get('notifications.reset-password.greeting') . '</div>'
                )
            )
            ->subject(
                new HtmlString(
                    Lang::get('notifications.reset-password.subject')
                )
            )
            ->line(
                new HtmlString(
                    '<div class="reason">' . Lang::get('notifications.reset-password.reason',
                        ['resetUrl' => env('FRONT_URL') . '/password/reset?email=' . $notifiable->email . '&token=' . $this->token]) . '</div>'
                )
            )
            ->action(
                Lang::get('notifications.reset-password.action'),
                env('FRONT_URL') . '/password/reset?email=' . $notifiable->email . '&token=' . $this->token
            )
            ->line(
                new HtmlString(
                    '<div class="expire">' . Lang::get('notifications.reset-password.expire',
                        ['count' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire')]) . '</div>'
                )
            )
            ->line(
                new HtmlString(
                    '<div class="note">' . Lang::get('notifications.reset-password.note') . '</div>'
                )
            )
            ->salutation(
                new HtmlString(
                    '<p class="salutation">' . Lang::get('notifications.reset-password.salutation', [
                        'frontUrl' => env('APP_URL')
                    ]). '</p>'
                )
            );
    }
}
