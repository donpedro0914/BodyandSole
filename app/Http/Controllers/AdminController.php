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

    public function save_settings($id, Request $request) {
        $data = array(
            'title' => $request->input('system_title')
        );

        Settings::where('id', $id)->update($data);

        $settings = Settings::where('id', $id)->first();

        return response()->json($settings);
    }

    public function rooms_view() {

        $rooms = Rooms::all();
        return view('admin.rooms', compact('rooms'));
    }

    public function add_room(Request $request) {
        $data = array(
            'room_name' => $request->input('room_name'),
            'status' => 'Available'
        );

        $add_room = Rooms::create($data);

        return response()->json($add_room);
    }

    public function edit_room($id, Request $request) {
        $rooms = Rooms::where('id', $id)->first();
        return view('admin.edit.rooms', ['rooms' => $rooms]);
    }

    public function update_room($id, Request $request) {
        $data = array(
            'room_name' => $request->input('room_name'),
            'status' => $request->input('status')
        );

        Rooms::where('id', $id)->update($data);

        $rooms = Rooms::where('id', $id)->first();
        return response()->json($rooms);     

    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect('/login');
    }

}
