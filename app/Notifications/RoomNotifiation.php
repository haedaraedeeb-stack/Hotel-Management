<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RoomNotifiation extends Notification
{
    use Queueable;

    public $room_id;
    public $user_name;
    public $room_number;
    /**
     * Create a new notification instance.
     */
    public function __construct($room_number, $user_name, $room_id)
    {
        $this->user_name = $user_name;
        $this->room_number = $room_number;
        $this->room_id = $room_id;
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
            'message' => 'Room ' . $this->room_number . ' has been created by ' . $this->user_name,
            'room_id' => $this->room_id,
        ];
    }
}
