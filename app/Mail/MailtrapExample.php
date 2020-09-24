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
    protected $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($password, $name)
    {
        $this->name = $name;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@madaresonajo.com', 'MadaresonaJo')
            ->subject('Madaresona Confirmation')
            ->markdown('mails.email')
            ->with([
                'name' => $this->name,
                'password' => $this->password
            ]);
    }
}
