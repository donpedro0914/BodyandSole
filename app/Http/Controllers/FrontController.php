<?php

namespace App\Http\Controllers;

use App\Rooms;
use App\Therapist;
use App\Services;
use App\Packages;
use App\JobOrder;
use App\Clients;
use App\Giftcertificate;
use Carbon\Carbon;
use DB;
use DataTables;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index() {

    	$now = Carbon::now()->format('Y-m-d');
        $en = Carbon::parse($now);
        $start = $en->startOfWeek(Carbon::FRIDAY);
        $end = $en->endOfWeek(Carbon::THURSDAY);
        $currentDay = Carbon::now();
        $day = $currentDay->dayOfWeek;
        $startDate = $en->startOfWeek(Carbon::FRIDAY)->format('Y-m-d');
        $endDate = $en->endOfWeek(Carbon::THURSDAY)->format('Y-m-d');

    	$therapists = DB::select('select * from therapists where basic IS NULL and id not in (select therapist_fullname from job_orders where status ="Active")
            union
            select * from therapists where basic IS NULL and id not in (select therapist_fullname from job_orders)');

        $rooms = DB::select('
            select rooms_lounges.status as roomstatus, rooms_lounges.name as roomname, rooms_lounges.id as roomid, a.*, b.fullname as therapistname from rooms_lounges
            left join (select * from job_orders where job_orders.status="Active") as a on rooms_lounges.id = a.room_no_form
            left join (select * from therapists) as b on a.therapist_fullname = b.id where rooms_lounges.type ="room" order by rooms_lounges.id asc');

        $lounge = DB::select('
            select rooms_lounges.status as roomstatus, rooms_lounges.name as roomname, rooms_lounges.id as roomid, a.*, b.fullname as therapistname from rooms_lounges
            left join (select * from job_orders where job_orders.status="Active") as a on rooms_lounges.id = a.room_no_form
            left join (select * from therapists) as b on a.therapist_fullname = b.id where rooms_lounges.type ="lounge" order by rooms_lounges.id asc');

        $service = Services::where('status', 'Active')->get();
        $packages = Packages::where('status', 'Active')->get();
        $client = Clients::all();
        $jobOrderCount = JobOrder::count();
        return view('home', compact('rooms', 'lounge', 'therapists', 'day', 'service', 'packages', 'client'), ['jobOrderCount' => $jobOrderCount, 'day' => $day]);
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
    		'senior' => $request->input('senior'),
    		'therapist_fullname' => $request->input('therapist_fullname'),
    		'category' => $request->input('category'),
    		'service' => $request->input('service'),
    		'payment' => $request->input('payment'),
    		'care_of' => $request->input('care_of'),
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

    public function checker(Request $request) {
        $checkgc = Giftcertificate::where('gc_no', request('gc_no'))->first();

        if($checkgc) {
            return response()->json($checkgc);
        }        
    }

    public function checkavailable() {
        $joborder = request('job_order');
        $rooms = DB::select('
            select rooms_lounges.status, rooms_lounges.name, rooms_lounges.id, a.*, b.fullname as therapistname from rooms_lounges
            left join (select * from job_orders where job_orders.status="Active") as a on rooms_lounges.id = a.room_no_form
            left join (select * from therapists) as b on a.therapist_fullname = b.id order by rooms_lounges.id asc');

        return response()->json($rooms);
    }

    public function f_clients() {
        $client = Clients::select('clients.*', 'job_orders.job_order', 'job_orders.client_fullname', 'job_orders.therapist_fullname', 'therapists.id', 'therapists.fullname as therafullname', 'job_orders.created_at as lastvisit')
                ->leftJoin('job_orders', 'clients.fullname', '=', 'job_orders.client_fullname')
                ->leftJoin('therapists', 'job_orders.therapist_fullname', '=', 'therapists.id')
                ->groupBy('therapists.id')
                ->orderBy('job_orders.created_at', 'desc')
                ->get();

        return view('clients', compact('client'));
    }

    public function f_client_store(Request $request)
    {
        $data = array(
            'fullname' => $request->input('fullname'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'dob' => $request->input('dob'),
            'occupation' => $request->input('occupation'),
            'sc_id' => $request->input('sc_id')
        );

        $client = Clients::create($data);

        return response()->json($client);
    }

    public function f_gift_certificate() {
        $gc = DB::select('select t.*, COALESCE(a.gcount,0) gcounts, service_name
            from giftcertificates t
            left join (
                select gcno, status, count(*) gcount
                from job_orders
                WHERE status = "Done"
                group by gcno
            ) a on t.gc_no = a.gcno
            left join (
                select id, service_name
                from services
            ) b on t.service = b.id');
        $client = Clients::all();
        $services = Services::where('status', 'Active')->get();

        return view('gc', compact('services', 'gc', 'client'));
    }

    public function f_gc_store(Request $request) {
        $data = array(
            'gc_no' => $request->input('gc_no'),
            'purchased_by' => $request->input('purchased_by'),
            'service' => $request->input('service'),
            'value' => $request->input('value'),
            'use' => $request->input('use'),
            'date_issued' => $request->input('date_issued'),
            'expiry_date' => $request->input('expiry_date'),
            'status' => 'Active'
        );

        $gcAdd = Giftcertificate::create($data);
        $gc = Giftcertificate::where('id', $gcAdd->id)->first();
        return response()->json($gc);
    }

    public function transfer(Request $request) {
        $roomid = Rooms::where('name', request('room_no_form'))->first();
        $data = array(
            'room_no_form' => $roomid->id,
            'duration' => NULL
        );

        $transfer = JobOrder::where('job_order', request('job_order'))->update($data);
        return response()->json($transfer);
    }

    public function f_petty_expenses() {
        return view('expenses');
    }
}
