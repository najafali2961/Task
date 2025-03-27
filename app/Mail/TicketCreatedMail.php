<?php

namespace App\Mail;

use App\Models\Tickets;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $editLink;

    /**
     * Create a new message instance.
     *
     * @param Tickets $ticket
     * @param string  $editLink
     */
    public function __construct(Tickets $ticket, string $editLink)
    {
        $this->ticket = $ticket;
        $this->editLink = $editLink;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Ticket Created')
            ->view('emails.ticket_created');
    }
}
