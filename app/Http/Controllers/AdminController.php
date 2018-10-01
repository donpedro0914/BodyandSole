<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use App\Settings;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.dashboard');
    }

    public function settings() {

        $settings = DB::table('settings')->first();

        return view('admin.settings', compact('settings'));
    }

    public function save_settings(Request $request) {
        $data = array(
            'title' => $request->input('system_title'),
            'rooms' => $request->input('system_room')
        );

        $settings = Settings::create($data);

        return response()->json($settings);
    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect('/login');
    }

}
