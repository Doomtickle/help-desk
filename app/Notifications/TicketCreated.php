<?php

namespace App\Notifications;

use App\User;
use App\TroubleTicket;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TicketCreated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $ticket;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(TroubleTicket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
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
                    ->subject('A new ticket has been created for ' . $this->ticket->website)
                    ->line('Description: ' . $this->ticket->description)
                    ->action('View Ticket', 'http://helpdesk.dev');
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

        return [
            'message' => $creator->name . ' created a ticket for ' . $this->ticket->website,
            'ticketId' => $this->ticket->id, 
        ];
    }
}
