<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use App\Settings;
use App\Rooms;
use App\JobOrder;
use App\User;
use App\Giftcertificate;
use App\PettyExpense;
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
        $dailyExpenses = PettyExpense::whereDate('created_at', Carbon::today())->sum('value');
        $dailyJobOrderDone = JobOrder::where('status', 'Done')->whereDate('created_at', Carbon::today())->count();
        $dailyJobOrderCancelled = JobOrder::where('status', 'Cancelled')->whereDate('created_at', Carbon::today())->count();

        $date = date('d');
        for($i=1; $i<=$date; $i++) {
            $days[] = $i;
            $totalDoneJobOrders[] = JobOrder::where('status', 'Done')->whereDay('created_at', '=', $i)->whereMonth('created_at', date('m'))->count();
            $totalCancelledJobOrders[] = JobOrder::where('status', 'Cancelled')->whereDay('created_at', '=', $i)->whereMonth('created_at', date('m'))->count();
        }
        $chartjs = app()->chartjs
        ->name('lineChartTest')
        ->type('line')
        ->size(['width' => 400, 'height' => 200])
        ->labels($days)
        ->datasets([
            [
                "label" => "Done Job Orders",
                'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                'borderColor' => "rgba(38, 185, 154, 0.7)",
                "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => $totalDoneJobOrders,
            ],
            [
                "label" => "Cancelled Job Orders",
                'backgroundColor' => "rgba(243, 73, 67, 0.31)",
                'borderColor' => "rgba(243, 73, 67, 0.7)",
                "pointBorderColor" => "rgba(243, 73, 67, 0.7)",
                "pointBackgroundColor" => "rgba(243, 73, 67, 0.7)",
                "pointHoverBackgroundColor" => "rgba(243, 73, 67, 1)",
                "pointHoverBorderColor" => "rgba(243, 73, 67, 1)",
                'data' => $totalCancelledJobOrders,
            ]
        ])
        ->options([]);

        return view('admin.dashboard', compact('chartjs'), ['day' => $day, 'dailySales' => $dailySales, 'dailyExpenses' => $dailyExpenses, 'dailyJobOrderDone' => $dailyJobOrderDone, 'dailyJobOrderCancelled' => $dailyJobOrderCancelled]);
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

    public function delete_room($id)
    {
        $room = Rooms::find($id)->delete();

        return response()->json($room);

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
