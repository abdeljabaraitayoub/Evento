<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendTicket extends Mailable
{
    use Queueable, SerializesModels;

    public $attachmentPath;
    /**
     * Create a new message instance.
     */
    public function __construct($attachmentPath = Null)
    {
        $this->attachmentPath = $attachmentPath;
    }


    public function build()
    {
        $email = $this->subject('ticket');

        if ($this->attachmentPath) {
            $email->view('ticket', ['qrCode' => $this->attachmentPath])
                ->attach($this->attachmentPath, [
                    'as' => 'reset_password.pdf',
                    'mime' => 'application/pdf',
                ]);
        }

        return $email;
    }
}
