<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;

class LogSuccessfulLogin
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
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        //insert to login activity
        $ac=new \App\Userloginactivity;
        $ac->user_id=auth()->user()->id;
        $ac->ip_address=\Request::ip();
        $ac->user_agent=\Request::server('HTTP_USER_AGENT');
        $ac->activity="LOGIN";
        $ac->save();
    }
}
