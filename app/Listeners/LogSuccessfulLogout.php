<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogSuccessfulLogout
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        $ac=new \App\Userloginactivity;
        $ac->user_id=auth()->user()->id;
        $ac->ip_address=\Request::ip();
        $ac->user_agent=\Request::server('HTTP_USER_AGENT');
        $ac->activity="LOGOUT";
        $ac->save();
    }
}
