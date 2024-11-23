<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MainNotification extends Notification
{
    use Queueable;

    public $data,$type;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(mixed $data,?string $type)
    {
        $this->data = $data;
        $this->type = is_null($type) ? "audit" : $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via(mixed $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray(mixed $notifiable): array
    {
        return [
            "type" => $this->type,
            "data" => $this->data,
        ];
    }
}
