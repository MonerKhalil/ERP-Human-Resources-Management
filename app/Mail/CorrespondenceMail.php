<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CorrespondenceMail extends Mailable
{
    use Queueable, SerializesModels;

    private $data;
    private $subjectMail;
    private $bladeMail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data,$subject,$bladeMail = null)
    {
        $this->data = $data;
        $this->subjectMail = $subject;
        $this->bladeMail = $bladeMail ?? 'System.Pages.Email.globalPageEmail';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subjectMail)
            ->markdown($this->bladeMail)
            ->with(["data" => $this->data]);
    }
}
