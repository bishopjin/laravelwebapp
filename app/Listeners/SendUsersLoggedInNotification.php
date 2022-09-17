<?php

namespace App\Listeners;

use App\Events\UsersLoggedIn;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendUsersLoggedInNotification
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
     * @param  \App\Events\UsersLoggedIn  $event
     * @return void
     */
    public function handle(UsersLoggedIn $event)
    {
        //
    }
}
