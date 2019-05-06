<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReplicatecekMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $errornya;

    public function __construct($errornya)
    {
        $this->errornya=$errornya;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $to=array('diandra.satyasari@mncgroup.com','kurnia.hapsari@mncgroup.com');
        $cc=array('jamal.apriadi@mncgroup.com');

        return $this->from('admin.marketing@mncgroup.com','ADMIN MARKETING')
                    ->cc(['mujib.nashikha@mncgroup.com','jaenudin.fawwaz@mncgroup.com','fitri.khoirunnisa@mncgroup.com','elga.triana@mncgroup.com','tertia.dewi@mncgroup.com','herdi.noprizal@mncgroup.com'])
                    ->subject('REPLICATE DATABASE ERROR')
                    ->view('emails.replicate_cek');
    }
}
