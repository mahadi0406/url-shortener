<?php

namespace App\Listeners;

use App\Events\TrackingVisitorEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Jenssegers\Agent\Agent;
use Stevebauman\Location\Facades\Location;
use App\Models\Visitor;

class CreateVisitorListener
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
        $location = Location::get(request()->ip());
        $address = [
            'zip' => @$location->zip,
            'city' => @$location->city,
        ];
        $agent = new Agent();
        Visitor::create([
            'short_link_id'=> $event->link->id,
            'location'     => $address,
            'latitude'     => @$location->lat,
            'longitude'    => @$location->lon,
            'ip'           => request()->ip(),
            'os'           => $agent->platform(),
            'browser'      => $agent->browser(),
            'device'       => $agent->device(),
            'country'      => @$location->country,
        ]);
    }
}
