<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendUsers extends Mailable
{
    use Queueable, SerializesModels;
    private $xml_path;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($xml_path)
    {
        $this->xml_path = $xml_path;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
        ->view('emails.sendUsers')
        ->attach($this->xml_path);
    }
}
