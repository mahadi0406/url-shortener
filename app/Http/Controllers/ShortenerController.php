<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortLink;
use App\Models\Visitor;
use App\Http\Utility\HashCodeGenerator;
use App\Http\Requests\ShortenerRequest;
use Illuminate\Support\Facades\Auth;
use App\Events\TrackingVisitorEvent;

class ShortenerController extends Controller
{
    
    public function create()
    {
        return view('welcome');
    }

    public function store(ShortenerRequest $request)
    {
        $user = Auth::user();
        $shorten = new ShortLink;
        if($user){
            $shorten->user_id = $user->id;
        }
        $shorten->main_url = $request->url;
        $shorten->hash = HashCodeGenerator::create();
        $shorten->number = $request->number;
        $shorten->expiry_time = $request->expiry;
        $shorten->expiry_date = $request->expiry_date;
        $shorten->save();
        $notify[]=['success','URL has been shorted successfully'];
        return back()->withNotify($notify);
    }


    public function process($hash)
    {
        $link = ShortLink::where('hash', $hash)->first();
        if(!$link){
            return redirect('/')->with(['error' => 'This URL is non existent']);
        }
        TrackingVisitorEvent::dispatch($link);
        return view('link')
    }


}
