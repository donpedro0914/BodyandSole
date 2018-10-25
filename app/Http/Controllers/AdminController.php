<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use App\Settings;
use App\Rooms;
use App\JobOrder;
use App\User;
use App\Giftcertificate;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $now = Carbon::now();
        $start = $now->startOfWeek(Carbon::FRIDAY);
        $end = $now->endOfWeek(Carbon::THURSDAY);
        $day = Carbon::now()->format('Y-m-d');
        $startDate = $now->startOfWeek(Carbon::FRIDAY)->format('Y-m-d');
        $endDate = $now->endOfWeek(Carbon::THURSDAY)->format('Y-m-d');
        $dailySales = DB::table('job_orders')
                    ->where('status', 'Done')
                    ->whereDate('created_at', Carbon::today())
                    ->sum('price');
        $dailySales += Giftcertificate::whereDate('created_at', Carbon::today())->sum('value');
        return view('admin.dashboard',['day' => $day, 'dailySales' => $dailySales]);
    }

    public function settings() {

        $settings = DB::table('users')->first();

        return view('admin.settings', compact('settings'));
    }

    public function save_settings($id, Request $request) {

        if(empty($request->input('password'))) {

            $data = array(
                'title' => $request->input('system_title'),
                'email' => $request->input('email')
            );

            User::where('id', $id)->update($data);

            $settings = User::where('id', $id)->first();

            return response()->json($settings);

        } else {

            $data = array(
                'title' => $request->input('system_title'),
                'email' => $request->input('email'),
                'adminpass' => $request->input('password'),
                'password' => Hash::make($request->input('password'))
            );

            User::where('id', $id)->update($data);

            Auth::logout();

            return redirect('/login');

        }

        
    }

    public function rooms_view() {

        $rooms = Rooms::all();
        return view('admin.rooms', compact('rooms'));
    }

    public function add_room(Request $request) {
        $data = array(
            'name' => $request->input('name'),
            'type' => $request->input('type'),
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
