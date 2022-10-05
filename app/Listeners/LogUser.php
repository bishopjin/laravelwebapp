<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\UsersLoggedIn;
use App\Models\InventoryEmployeeLog;

class LogUser
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(UsersLoggedIn $event)
    {
        if ($event->process == 'logout') {
            InventoryEmployeeLog::whereNull('time_out')
                ->where([
                ['time_in', 'like', date('Y-m-d').'%'],
                ['user_id', '=', $event->user->id]
            ])->update([
                'time_out' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
            ]);
        } else {
            InventoryEmployeeLog::create([
                'user_id' => $event->user->id,
                'time_in' => date('Y-m-d h:i:s'),
            ]);
        }
    }
}
