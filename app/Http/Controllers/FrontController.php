<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rooms;
use App\Therapist;
use App\Services;
use App\Packages;
use Carbon\Carbon;

class FrontController extends Controller
{
    public function index() {

    	$day = Carbon::now()->format( 'N' );
    	$therapists = Therapist::where('status', 'Active')->get();
        $rooms = Rooms::all();
        $service = Services::where('status', 'Active')->get();
        $packages = Packages::where('status', 'Active')->get();
        return view('home', compact('rooms', 'therapists', 'day', 'service', 'packages'));
    }
}
