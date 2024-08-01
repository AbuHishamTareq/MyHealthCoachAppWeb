<?php

namespace App\Notifications;

use App\Models\Patient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewTransferRequest extends Notification
{
    use Queueable;
    private $sender;
    private $message;
    private $sender_image;
    private $patient;
    private $uid;
    /**
     * Create a new notification instance.
     */
    public function __construct($sender, $message, $sender_image, $patient, $uid)
    {
        $this->sender = $sender;
        $this->message = $message;
        $this->sender_image = $sender_image;
        $this->patient = $patient;
        $this->uid = $uid;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
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
            'sender' => $this->sender,
            'message' => $this->message,
            'sender_image' => $this->sender_image,
            'patient' => $this->patient,
            'uid' => $this->uid,
        ];
    }
}
