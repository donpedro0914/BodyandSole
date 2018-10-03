<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use App\Settings;
use App\Rooms;
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
            'title' => $request->input('system_title')
        );

        $settings = Settings::create($data);

        return response()->json($settings);
    }

    public function rooms_view() {

        $rooms = Rooms::all();
        return view('admin.rooms', compact('rooms'));
    }

    public function add_room(Request $request) {
        $data = array(
            'room_name' => $request->input('room_name'),
            'status' => '0'
        );

        $add_room = Rooms::create($data);

        return response()->json($add_room);
    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect('/login');
    }

}
