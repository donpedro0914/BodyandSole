<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class FrontController extends Controller
{
    public function index() {

        $settings = DB::table('settings')->first();
        return view('home', compact('settings'));
    }
}
