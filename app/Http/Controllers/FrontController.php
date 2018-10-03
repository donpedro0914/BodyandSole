<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rooms;

class FrontController extends Controller
{
    public function index() {

        $rooms = Rooms::all();
        return view('home', compact('rooms'));
    }
}
