<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifNarikData extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $sekarang;
    public $status;


    public function __construct($sekarang,$status)
    {
        $this->sekarang=$sekarang;
        $this->status=$status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $to=array('diandra.setyasari@mncgroup.com','kurnia.hapsari@mncgroup.com');
        $cc=array('jamal.apriadi@mncgroup.com');

        return $this->from('admin.marketing@mncgroup.com','ADMIN MARKETING')
                    ->cc(['diandra.setyasari@mncgroup.com','jamal.apriadi@mncgroup.com'])
                    ->subject('NOTIFIKASI TARIK OTOMATIS')
                    ->view('emails.notif_narik_data');
    }
}
