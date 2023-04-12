<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmployeeAdded extends Notification
{
    use Queueable;
    protected $tobaccoShop;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($tobaccoShop)
    {
        $this->tobaccoShop = $tobaccoShop;
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
                    ->subject('Dipendente')
                    ->greeting('Ciao ' . $notifiable->name)
                    ->line('Sei stato aggiunto come dipendente presso la tabaccheria ' . $this->tobaccoShop->name)
                    ->line('Se non le risulta di lavorare in quest\'azienda contatti il proprietario all\'email ' . $this->tobaccoShop->owner->email);
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
