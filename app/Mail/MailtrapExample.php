<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailtrapExample extends Mailable
{
    use Queueable, SerializesModels;
    protected $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($password)
    {
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('0e90b5d90d@emailmonkey.club', 'Mailtrap')
            ->subject('Madaresona Confirmation')
            ->markdown('mails.email')
            ->with([
                'name' => 'Admin',
                'link' => 'https://mailtrap.io/inboxes',
                'password' => $this->password
            ]);
    }
}
