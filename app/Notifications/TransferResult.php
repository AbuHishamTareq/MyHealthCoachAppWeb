<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransferResult extends Notification
{
    use Queueable;
    private $sender_id;
    private $sender;
    private $sender_image;
    private $message;

    /**
     * Create a new notification instance.
     */
    public function __construct($sender_id, $sender, $sender_image, $message)
    {
        $this->sender_id = $sender_id;
        $this->sender = $sender;
        $this->sender_image = $sender_image;
        $this->message = $message;
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
            'sender_id' => $this->sender_id,
            'sender' => $this->sender,
            'sender_image' => $this->sender_image,
            'message' => $this->message,
        ];
    }
}
