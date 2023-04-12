<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class sendEmailToDeleteTobaccoShop extends Notification
{
    use Queueable;
    public $tobaccoShop,$token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($tobaccoShop,$token)
    {
        $this->tobaccoShop = $tobaccoShop;
        $this->token = $token;
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
                    ->subject("Eliminazione Attività " . $this->tobaccoShop->name)
                    ->greeting('Ciao ' . $notifiable->name)
                    ->line("L'operazione deve essere approvata, per confermarla è necessario cliccare il link qui sotto")
                    ->action('Elimina',  url('/'. $this->tobaccoShop->id .'/'. $this->token .'/deleteTobaccoShop'))
                    ->line('Ricorda che questo token è valido per ' . \Config::get("scratchAndWinApp.MAX_MINUTES_TO_DELETE_TOBACCOSHOP")  . ' minuti, dopodiche è necessario rifare la procedura.');
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
