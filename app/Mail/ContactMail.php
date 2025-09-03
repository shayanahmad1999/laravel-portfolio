<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function build()
    {
        return $this->subject('📨 New Contact Message')
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->replyTo($this->payload['email'], $this->payload['name'])
            ->view('emails.contact');
    }
}
