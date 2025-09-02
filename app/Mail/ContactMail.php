<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $payload;

    public function __construct(array $payload){ $this->payload = $payload; }

    public function build(){
        return $this->subject('New Portfolio Contact')
            ->view('emails.contact');
    }
}
