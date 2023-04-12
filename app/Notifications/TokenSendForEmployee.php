<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TokenSendForEmployee extends Notification
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
                    ->subject('Sei stato invitato in GV Gestore')
                    ->greeting('Ciao hai ricevuto un invito')
                    ->line('Il proprietario della tabaccheria ' . $this->tobaccoShop->name . ' ha scelto te come suo dipendente' )
                    ->line('Ma non sei iscritto, quindi clicca qui per iscriverti')
                    ->action('Iscriviti', url('/'). '?' . http_build_query(['token' =>$notifiable->token]))
                    ->line('Se hai ricevuto quest\'email ma non lavori in una tabaccheria contatta ' . $this->tobaccoShop->owner->email );
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
