<?php

namespace App\Notifications\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NominationSubmit extends Notification implements ShouldQueue
{
    use Queueable;
    private $name;
    private $email;
    private $phone;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user_data)
    {
        $this->name = $user_data->name;
        $this->email = $user_data->email;
        $this->phone = $user_data->phone;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
        ->greeting('Hello '.$this->name.',')
        ->line('Your Nomination is Submitted.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
