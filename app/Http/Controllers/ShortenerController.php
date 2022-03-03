<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortLink;
use App\Http\Utility\HashCodeGenerator;
use App\Http\Requests\ShortenerRequest;
use Illuminate\Support\Facades\Auth;
use App\Events\TrackingVisitorEvent;
use Carbon\Carbon;
use App\Exports\VisitorExport;
use Maatwebsite\Excel\Facades\Excel;

class ShortenerController extends Controller
{
    
    public function create()
    {
        return view('welcome');
    }

    public function report()
    {

        return view('report');
    }

    public function export() 
    {
        return Excel::download(new VisitorExport, 'visitor.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }

    public function store(ShortenerRequest $request)
    {
        $user = Auth::user();
        $short=ShortLink::create([
                'user_id'    => $user ? $user->id : null,
                'main_url'   => $request->url,
                'hash'       => HashCodeGenerator::create(),
                'number'     => $request->number,
                'expiry_time'=> $request->expiry,
                'expiry_date'=> $request->expiry_date,
            ]);
        $request->session()->put('url', url('/').'/'.$short->hash);
        $notify[]=['success','URL has been shorted successfully'];
        return back()->withNotify($notify);
    }


    public function process($hash)
    {
        session()->forget('url');
        $link = ShortLink::where('hash', $hash)->first();
        if(!$link) {
            $notify[] = ['error', 'This URL is non existent'];
            return redirect('/')->withNotify($notify);
        }
        if($link->expiry_time == 1 && Carbon::now()->format('Y-m-d') >= $link->expiry_date){
            $notify[] = ['error', 'This URL currently expired'];
            return redirect('/')->withNotify($notify);
        }
        TrackingVisitorEvent::dispatch($link);
        return redirect($link->main_url);
    }


}
