<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MultipleEmails extends Mailable
{
    use Queueable, SerializesModels;
    protected $title;
    public $subject;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $subject)
    {
        $this->title = $title;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('omer@arakjo.com', 'MadaresonaJo')
            ->subject('Madaresona')
            ->markdown('mails.multipleEmails')
            ->with([
                'title' => $this->title,
                'subject' => $this->subject
            ]);
    }
}
