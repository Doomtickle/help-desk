<?php

namespace App\Notifications;

use App\User;
use App\TroubleTicket;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TicketUpdated extends Notification implements ShouldQueue
{
    protected $changed;
    protected $ticket;
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(TroubleTicket $ticket, $changed)
    {
        $this->ticket = $ticket;
        $this->changed = $changed;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', 'https://laravel.com')
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $creator = User::find($this->ticket->user_id);

        foreach($this->changed as $key => $value)
            $this->changed[$key] = $value;

        return [
            'message' => $creator->name . ' updated the ' . $key . ' on ' . $this->ticket->website . ' to ' . $value,
            'ticketId' => $this->ticket->id,
        ];
    }
}
