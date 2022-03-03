<?php

namespace App\Listeners;

use App\Events\TrackingVisitorEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;

class IpBlockListener
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
     * @param  \App\Events\TrackingVisitorEvent  $event
     * @return void
     */
    public function handle(TrackingVisitorEvent $event)
    {  
        if(Cache::has(request()->ip())){
            Cache::increment(request()->ip());
        }else{
            Cache::put(request()->ip(), 1, $seconds = 60);
        }
        if(Cache::get(request()->ip()) >= $event->link->number){
            Cache::put('ipblock'.request()->ip(), 'ipblock' , $seconds = 300);
        };
    }
}
