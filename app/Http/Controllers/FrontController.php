<?php

namespace App\Http\Controllers;

use App\Rooms;
use App\Therapist;
use App\Services;
use App\Packages;
use App\JobOrder;
use App\Clients;
use App\Giftcertificate;
use App\PettyExpense;
use App\Attendance;
use Carbon\Carbon;
use DB;
use DataTables;
use Illuminate\Http\Request;

include_once(app_path() . '\WebClientPrint\WebClientPrint.php');
use Neodynamic\SDK\Web\WebClientPrint;
use Neodynamic\SDK\Web\Utils;
use Neodynamic\SDK\Web\DefaultPrinter;
use Neodynamic\SDK\Web\InstalledPrinter;
use Neodynamic\SDK\Web\PrintFile;
use Neodynamic\SDK\Web\ClientPrintJob;
 
use Session;

class FrontController extends Controller
{
    public function index() {

        $wcpScript = WebClientPrint::createScript(action('WebClientPrintController@processRequest'), action('FrontController@printCommands'), Session::getId());

    	$now = Carbon::now()->format('Y-m-d');
        $en = Carbon::parse($now);
        $start = $en->startOfWeek(Carbon::FRIDAY);
        $end = $en->endOfWeek(Carbon::THURSDAY);
        $currentDay = Carbon::now();
        $formattedCurrentDay = Carbon::now()->format('Y-m-d');
        $day = $currentDay->dayOfWeek;
        $startDate = $en->startOfWeek(Carbon::FRIDAY)->format('Y-m-d');
        $endDate = $en->endOfWeek(Carbon::THURSDAY)->format('Y-m-d');

        $alltherapists = Therapist::where('status', 'Active')->get();

    	$therapists = DB::select('select * from therapists');

        $rooms = DB::select('
            select rooms_lounges.status as roomstatus, rooms_lounges.name as roomname, rooms_lounges.id as roomid, a.*, a.category as category, c.service_name as servicename, d.package_name as packagename, b.fullname as therapistname from rooms_lounges
            left join (select * from job_orders where job_orders.status="Active") as a on rooms_lounges.id = a.room_no_form
            left join (select * from services) as c on c.id = a.service
            left join (select * from packages) as d on d.id = a.service
            left join (select * from therapists) as b on a.therapist_fullname = b.id where rooms_lounges.type ="room" order by rooms_lounges.id asc');

        $lounge = DB::select('
            select rooms_lounges.status as roomstatus, rooms_lounges.name as roomname, rooms_lounges.id as roomid, a.*, a.category as category, c.service_name as servicename, d.package_name as packagename, b.fullname as therapistname from rooms_lounges
            left join (select * from job_orders where job_orders.status="Active") as a on rooms_lounges.id = a.room_no_form
            left join (select * from services) as c on c.id = a.service
            left join (select * from packages) as d on d.id = a.service
            left join (select * from therapists) as b on a.therapist_fullname = b.id where rooms_lounges.type ="lounge" order by rooms_lounges.id asc');

        $service = Services::where('status', 'Active')->get();
        $packages = Packages::where('status', 'Active')->get();
        $client = Clients::all();
        $joborder = JobOrder::select('job_orders.*', 'therapists.fullname as therapistname', 'services.service_name as service_name', 'services.id', 'packages.package_name as package_name')->leftJoin('therapists', 'job_orders.therapist_fullname', '=', 'therapists.id')->leftJoin('services', 'job_orders.service', '=', 'services.id')->leftJoin('packages', 'job_orders.service', '=', 'packages.id')->whereDate('job_orders.created_at', $formattedCurrentDay)->orderBy('job_orders.id', 'desc')->get();
        $jobOrderCount = JobOrder::count();
        return view('home', compact('rooms', 'lounge', 'alltherapists', 'therapists', 'day', 'service', 'packages', 'client', 'joborder'), ['wcpScript' => $wcpScript, 'jobOrderCount' => $jobOrderCount, 'day' => $day]);
    }

    public function printCommands(Request $request){
         

       if ($request->exists(WebClientPrint::CLIENT_PRINT_JOB)) {
 
            $useDefaultPrinter = ($request->input('useDefaultPrinter') === 'checked');
            $printerName = urldecode($request->input('printerName'));

            $jobInfo = JobOrder::select('job_orders.*', 'therapists.fullname as fullname', 'therapists.id', 'services.id', 'services.service_name as service_name')->leftJoin('therapists', 'job_orders.therapist_fullname', '=', 'therapists.id')->leftJoin('services', 'job_orders.service', '=', 'services.id')->where('job_order', $request->input('id'))->first();
             
            //Create ESC/POS commands for sample receipt
            $esc = '0x1B'; //ESC byte in hex notation
            $newLine = '0x0A'; //LF byte in hex notation
            
            $cmds = $esc . "@"; //Initializes the printer (ESC @)
            $cmds .= Carbon::now();
            $cmds .= $newLine;
            $cmds .= 'JOB ORDER: ' .$jobInfo->job_order;
            $cmds .= $newLine;
            $cmds .= 'CLIENT: ' . $jobInfo->client_fullname;
            $cmds .= $newLine;
            $cmds .= 'THERAPIST: ' . $jobInfo->fullname;
            $cmds .= $newLine;
            $cmds .= 'Room#: ' . $jobInfo->room_no_form;
            $cmds .= $newLine;
            $cmds .= 'Payment: ' . $jobInfo->payment;
            $cmds .= $newLine;
            $cmds .= 'Please render the following:';
            $cmds .= $newLine;
            $cmds .= '---------------------------------------';
            $cmds .= $newLine;
            $cmds .= 'SERVICE/PACKAGE                  CHARGE';
            $cmds .= $newLine;
            $cmds .= '---------------------------------------';
            $cmds .= $newLine;
            $cmds .= $jobInfo->service_name.'                       '.$jobInfo->price;
            $cmds .= $newLine;
            $cmds .= '---------------------------------------';
            $cmds .= $newLine;
            $cmds .= '                               Total:'.$jobInfo->price;
            $cmds .= $newLine;
            $cmds .= 'IN :___________';
            $cmds .= $newLine;
            $cmds .= 'OUT:___________'.'  '.'Thera:____________';
            $cmds .= $newLine;
            $cmds .= $newLine;
            $cmds .= $newLine;
            $cmds .= $newLine;
            $cmds .= $newLine;
            $cmds .= 'PLEASE PRESENT THIS'; 
            $cmds .= $newLine;
            $cmds .= 'TO YOUR ATTENDING THERAPIST';
 
            //Create a ClientPrintJob obj that will be processed at the client side by the WCPP
            $cpj = new ClientPrintJob();
            //set ESCPOS commands to print...
            $cpj->printerCommands = $cmds;
            $cpj->formatHexValues = true;
             
            if ($useDefaultPrinter || $printerName === 'null') {
                $cpj->clientPrinter = new DefaultPrinter();
            } else {
                $cpj->clientPrinter = new InstalledPrinter($printerName);
            }
         
            //Send ClientPrintJob back to the client
            return response($cpj->sendToClient())
                        ->header('Content-Type', 'application/octet-stream');
                 
             
        }
    } 

    public function getpackagedetails(Request $request) {
    	$packageDetails = Packages::where('id', $request->input('id'))->first();

    	return response()->json($packageDetails);
    }

    public function ajaxService(Request $request) {

        $service = Services::whereIn('id', request('id'))->get();
        return response()->json($service);

    }

    public function ajaxAddon(Request $request) {

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
    		'addon' => $request->input('addon'),
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

        $alltherapists = Therapist::where('status', 'Active')->get();
        $client = Clients::select('clients.*', 'job_orders.job_order', 'job_orders.client_fullname', 'job_orders.therapist_fullname', 'therapists.id', 'therapists.fullname as therafullname', 'job_orders.created_at as lastvisit')
                ->leftJoin('job_orders', 'clients.fullname', '=', 'job_orders.client_fullname')
                ->leftJoin('therapists', 'job_orders.therapist_fullname', '=', 'therapists.id')
                ->groupBy('therapists.id')
                ->orderBy('job_orders.created_at', 'desc')
                ->get();

        return view('clients', compact('client', 'alltherapists'));
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

        $alltherapists = Therapist::where('status', 'Active')->get();
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
        $gcCount = Giftcertificate::count();

        return view('gc', compact('services', 'gc', 'client', 'alltherapists'),['gcCount' => $gcCount]);
    }

    public function f_gc_store(Request $request) {
        $data = array(
            'gc_no' => $request->input('gc_no'),
            'ref_no' => $request->input('ref_no'),
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

        $alltherapists = Therapist::where('status', 'Active')->get();
        $therapist = Therapist::where('status', 'Active')->get();
        $expenses = PettyExpense::select('petty_expenses.*', 'therapists.id', 'therapists.fullname', 'petty_expenses.created_at as date')->leftJoin('therapists', 'petty_expenses.therapist', '=', 'therapists.id')->where('petty_expenses.value', '!=', '0')->whereDate('petty_expenses.created_at', Carbon::now()->format('Y-m-d'))->orderBy('petty_expenses.created_at', 'asc')->get();

        $expenseCount = PettyExpense::count();
        return view('expenses', compact('therapist', 'expenses', 'alltherapists'), ['expenseCount' => $expenseCount]);
    }

    public function attendance_store(Request $request) {
        $now = Carbon::now()->format('Y-m-d');
        $en = Carbon::parse($now);
        $start = $en->startOfWeek(Carbon::FRIDAY);
        $end = $en->endOfWeek(Carbon::THURSDAY);
        $currentDay = Carbon::now();
        $formattedCurrentDay = Carbon::now()->format('Y-m-d');
        $day = $currentDay->dayOfWeek;
        $startDate = $en->startOfWeek(Carbon::FRIDAY)->format('Y-m-d');
        $endDate = $en->endOfWeek(Carbon::THURSDAY)->format('Y-m-d');

        $validateUser = Therapist::where('fullname', $request->input('therapist'))->where('pin', $request->input('pin'))->first();

        $day = $request->input('day');
        if($validateUser) {
            $checkIn = Attendance::where('name', $validateUser->fullname)->first();
            if(empty($checkIn->time_in)) {
                $data = array(
                    'name' => $request->input('therapist'),
                    'time_in' => Carbon::now(),
                    $day => 1
                );

                $checkIn2 = Attendance::create($data);
                $checkIn3 = Attendance::where('id', $checkIn2->id)->first();
                return response()->json($checkIn3);
            } else {
                $data = array(
                    'name' => $request->input('therapist'),
                    'time_out' => Carbon::now()
                );
                Attendance::where('name', $request->input('therapist'))->update($data);

                $updateAttendance = Attendance::where('name', $request->input('therapist'))->first();
                return response()->json($updateAttendance);
            }
        } else {
            return false;
        }
    }

    public function f_expense_store(Request $request) {
        $data = array(
            'therapist' => $request->input('therapist'),
            'category' => $request->input('category'),
            'value' => $request->input('value')
        );

        $expenseAdd = PettyExpense::create($data);
        $expense = PettyExpense::where('id', $expenseAdd->id)->first();
        return response()->json($expense);
    }

    

    public function f_payroll() {

        $now = Carbon::now();
        $start = $now->startOfWeek(Carbon::FRIDAY);
        $end = $now->endOfWeek(Carbon::THURSDAY);
        $day = $start->format('N');
        $startDate = $now->startOfWeek(Carbon::FRIDAY)->format('Y-m-d');
        $endDate = $now->endOfWeek(Carbon::THURSDAY)->format('Y-m-d');
        $alltherapists = Therapist::where('status', 'Active')->get();

        $payroll = DB::select('
            select b.fullname , COALESCE(b.basic,0) as basic, COALESCE(b.allowance,0) as allowance, COALESCE(b.lodging,0) as lodging, COALESCE(b.sss,0) as sss, COALESCE(b.phealth,0) as phealth, COALESCE(b.hdf,0) as hdf, sum(COALESCE(b.uniform,0) + COALESCE(b.fare,0) + COALESCE(b.others,0)) as others, 
            sum(COALESCE(a.day0,0) + COALESCE(a.day1,0) + COALESCE(a.day2,0) + COALESCE(a.day3,0) + COALESCE(a.day4,0) + COALESCE(a.day5,0) + COALESCE(a.day6,0)) as total, sum(COALESCE(a.day0,0)) as Fri, sum(COALESCE(a.day1,0)) as Sat, sum(COALESCE(a.day2,0)) as Sun, sum(COALESCE(a.day3,0)) as Mon, sum(COALESCE(a.day4,0)) as Tue, sum(COALESCE(a.day5,0)) as Wed, sum(COALESCE(a.day6,0)) as Thurs
            from job_orders a, therapists b
            where a.therapist_fullname=b.id
            and DATE_FORMAT(a.created_at, "%Y-%m-%d") BETWEEN DATE_FORMAT("'.$startDate.'", "%Y-%m-%d") AND DATE_FORMAT("'.$endDate.'", "%Y-%m-%d")
            group by b.fullname
            union
            select b.fullname ,COALESCE(b.basic,0) as basic, COALESCE(b.allowance,0) as allowance, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0
            from job_orders a, therapists b
            where  b.id not in (select distinct a.therapist_fullname from job_orders a)
            group by b.fullname
            ');

        return view('payroll', compact('alltherapists', 'payroll'), ['startDate' => $startDate, 'endDate' => $endDate]);
    }
}
