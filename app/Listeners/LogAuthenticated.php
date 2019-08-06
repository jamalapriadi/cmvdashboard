<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Authenticated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogAuthenticated
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public $info;


    public function __construct($info)
    {
        $this->info = $info;
    }

    /**
     * Handle the event.
     *
     * @param  Authenticated  $event
     * @return void
     */
    public function handle(Authenticated $event)
    {
        //
    }
}
