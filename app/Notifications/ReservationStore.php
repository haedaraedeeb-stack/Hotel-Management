<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReservationStore extends Notification
{
    use Queueable;

    public $reservation_id;
    public $user_name;
    public $room_number;
    /**
     * Create a new notification instance.
     */
    public function __construct($reservation_id, $user_name, $room_number)
    {
        $this->reservation_id = $reservation_id;
        $this->user_name = $user_name;
        $this->room_number = $room_number;
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
            'message' => 'Room ' . $this->room_number . ' reservation request by ' . $this->user_name,
            'reservation_id' => $this->reservation_id,
            'user_name' => $this->user_name,
            'room_number' => $this->room_number
        ];
    }
}
