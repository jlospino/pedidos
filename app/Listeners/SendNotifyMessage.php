<?php

namespace App\Listeners;

use App\Events\NotifyMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNotifyMessage
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
     * @param  NotifyMessage  $event
     * @return void
     */
    public function handle(NotifyMessage $event)
    {
        return "Hola Mundo";
    }
}
