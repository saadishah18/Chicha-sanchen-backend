<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OTPEmail extends Notification implements ShouldQueue
{
    use Queueable;

    public $otp_code;
    public $custom_title;

    /**
     * Create a new notification instance.
     */
    public function __construct($otp_code,$title)
    {
        $this->otp_code = $otp_code;
        $this->custom_title = $title;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject(ucfirst($this->custom_title))
                    ->line('The introduction to the notification.')
                    ->line('Your OTP Code is: ' . $this->otp_code)
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
