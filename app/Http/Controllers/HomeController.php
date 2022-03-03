<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortLink;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $shortLinks = ShortLink::where('user_id', $user->id)->orderBy('id', 'DESC')->get();
        return view('dashboard', compact('shortLinks'));
    }

}
