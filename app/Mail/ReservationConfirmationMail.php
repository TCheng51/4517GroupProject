<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Reservation $reservation,
        public string $action = 'created'
    ) {
        $this->reservation->loadMissing(['member', 'room', 'timeSlot', 'reservationMenuItems.menuItem']);
    }

    public function envelope(): Envelope
    {
        $subject = match ($this->action) {
            'updated' => 'Your Fable reservation was updated',
            'cancelled' => 'Your Fable reservation was cancelled',
            'confirmed' => 'Your Fable reservation was confirmed',
            default => 'Your Fable reservation confirmation',
        };

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reservation-confirmation'
        );
    }
}
