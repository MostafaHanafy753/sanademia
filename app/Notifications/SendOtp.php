<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendOtp extends Notification
{
    use Queueable;
    protected string $otp;
    /**
     * Create a new notification instance.
     */
    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['whatsapp'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toWhatsapp($notifiable)
    {
        return [
            'from' => config('services.twilio.whatsapp_from'), // e.g., "whatsapp:+14155238886"
            'to'   => "whatsapp:" . $notifiable->phone,
            'body' => "Your OTP is: {$this->otp}",
        ];
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
