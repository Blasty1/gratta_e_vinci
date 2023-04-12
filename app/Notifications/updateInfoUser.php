<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class updateInfoUser extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
            ->subject('Dati Aggiornati')
            ->greeting('Ciao ' . $notifiable->name)
            ->line('Ti informiamo che sono stati aggiornati i tuoi dati: nome, cognome , indirizzo ed email.')
            ->line('Se non sei stato tu contattaci immediatamente cliccando qui sotto, oppure all\'email ' . \Config::get('mail.from.address'))
            ->action('Contattaci', 'mailto:' . \Config::get('mail.from.address'))
            ->line('Altrimenti ignora questa email , buon lavoro.');
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
