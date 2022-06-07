<?php

namespace App\Listeners;

use App\Events\CreateEvents;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateEventsListeners
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
     * @param  \App\Events\CreateEvents  $event
     * @return void
     */
    public function handle(CreateEvents $event)
    {
        //
    }
}
