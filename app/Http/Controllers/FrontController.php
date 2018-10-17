<?php

namespace App\Http\Controllers;

use App\Rooms;
use App\Therapist;
use App\Services;
use App\Packages;
use App\JobOrder;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index() {

    	$now = Carbon::now();
        $start = $now->startOfWeek(Carbon::FRIDAY);
        $end = $now->endOfWeek(Carbon::THURSDAY);
        $currentDay = $now->dayOfWeekIso;
        $startDate = $now->startOfWeek(Carbon::FRIDAY)->format('Y-m-d');
        $endDate = $now->endOfWeek(Carbon::THURSDAY)->format('Y-m-d');

    	$therapists = DB::select('select * from therapists where basic IS NULL and id not in (select therapist_fullname from job_orders where status ="Active")
            union
            select * from therapists where basic IS NULL and id not in (select therapist_fullname from job_orders)');

        $rooms = DB::select('
            select rooms.status as roomstatus, rooms.room_name as roomname, rooms.id as roomid, a.*, b.fullname as therapistname from rooms
            left join (select * from job_orders where job_orders.status="Active") as a on rooms.id = a.room_no_form
            left join (select * from therapists) as b on a.therapist_fullname = b.id order by rooms.id asc');

        $service = Services::where('status', 'Active')->get();
        $packages = Packages::where('status', 'Active')->get();
        $jobOrderCount = JobOrder::count();
        return view('home', compact('rooms', 'therapists', 'day', 'service', 'packages'), ['jobOrderCount' => $jobOrderCount, 'currentDay' => $currentDay]);
    }

    public function getpackagedetails(Request $request) {
    	$packageDetails = Packages::where('id', $request->input('id'))->first();

    	return response()->json($packageDetails);
    }

    public function ajaxService(Request $request) {

        $service = Services::whereIn('id', request('id'))->get();
        return response()->json($service);

    }

    public function store(Request $request) {

        $day = $request->input('day');
    	$data = array(
    		'job_order' => $request->input('job_order'),
    		'room_no_form' => $request->input('room_no'),
    		'client_fullname' => $request->input('client_fullname'),
    		'therapist_fullname' => $request->input('therapist_fullname'),
    		'category' => $request->input('category'),
    		'service' => $request->input('service'),
    		'payment' => $request->input('payment'),
    		'careof' => $request->input('careof'),
            'gcno' => $request->input('gcno'),
    		'price' => $request->input('price'),
    		'status' => 'Active',
            $day => $request->input('commmission')
    	);

    	$jo = JobOrder::create($data);
    	$jobOrder = JobOrder::where('job_order', $jo->job_order)->first();

    	return response()->json($jobOrder);
    }

    public function update(Request $request) {

        $data = array(
            'status' => 'Done'
        );

        $jobOrderUpdate = JobOrder::where('job_order', request('job_order'))->update($data);

        return response()->json($jobOrderUpdate);
    }

    public function cancelupdate(Request $request) {

        $data = array(
            'status' => 'Cancelled'
        );

        $jobOrderUpdate = JobOrder::where('job_order', request('job_order'))->update($data);

        return response()->json($jobOrderUpdate);
    }

    public function duration(Request $request) {

        $date = date('Y-m-d H:i:s');

        $data = array(
            'duration' => date('Y-m-d H:i:s', strtotime('+'.request('hr').' hour +'.request('min').' minutes', strtotime($date)))
        );

        JobOrder::where('job_order', request('job_order'))->update($data);
        $jobOrderDuration = JobOrder::where('job_order', request('job_order'))->first();

        return response()->json($jobOrderDuration);
    }
}
