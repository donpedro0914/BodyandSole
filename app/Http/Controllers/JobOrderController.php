<?php

namespace App\Http\Controllers;

use App\Rooms;
use App\Therapist;
use App\Services;
use App\Packages;
use App\JobOrder;
use App\Clients;
use App\Giftcertificate;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JobOrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

    	$now = Carbon::now()->format('Y-m-d');
        $en = Carbon::parse($now);
        $start = $en->startOfWeek(Carbon::FRIDAY);
        $end = $en->endOfWeek(Carbon::THURSDAY);
        $currentDay = Carbon::now();
        $day = $currentDay->dayOfWeek;
        $startDate = $en->startOfWeek(Carbon::FRIDAY)->format('Y-m-d');
        $endDate = $en->endOfWeek(Carbon::THURSDAY)->format('Y-m-d');


        $joborder = JobOrder::select('job_orders.*', 'therapists.fullname as therapistname')->leftJoin('therapists', 'job_orders.therapist_fullname', '=', 'therapists.id')->orderBy('job_orders.id', 'desc')->get();

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

        $jobOrderCount = JobOrder::count();
        $service = Services::where('status', 'Active')->get();
        $packages = Packages::where('status', 'Active')->get();
        $client = Clients::all();

        return view('admin.job_order', compact('joborder', 'therapists', 'rooms', 'lounge', 'service', 'packages', 'client'), ['jobOrderCount' => $jobOrderCount, 'day' => $day]);
    }

    public function edit($id) {
        $joborder = JobOrder::select('job_orders.*', 'services.service_name', 'services.id', 'services.service_name as sname')->leftJoin('services', 'job_orders.service', '=', 'services.id')->where('job_orders.id', $id)->first();
        $therapists = Therapist::where('status', 'Active')->get();
        $service = Services::where('status', 'Active')->get();

        return view('admin.edit.joborder', compact('therapists', 'service'), ['joborder' => $joborder]);
    }

    public function update(Request $request, $id) {
        $data = array(
            'client_fullname' => $request->input('client_fullname'),
            'therapist_fullname' => $request->input('therapist_fullname'),
            'category' => $request->input('category'),
            'service' => $request->input('service'),
            'payment' => $request->input('payment'),
            'care_of' => $request->input('care_of'),
            'gcno' => $request->input('gcno'),
            'price' => $request->input('price')
        );

        JobOrder::where('id', $id)->update($data);
        return back();
    }

    public function delete($id)
    {
        $joborder = JobOrder::find($id)->delete();

        return response()->json($joborder);

    }

}
