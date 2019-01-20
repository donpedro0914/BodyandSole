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

        $alltherapists = Therapist::where('status', 'Active')->where('basic', '!=', NULL)->get();

    	$therapists = DB::select('select * from therapists');

        $rooms = DB::select('
            select rooms_lounges.status as roomstatus, rooms_lounges.name as roomname, rooms_lounges.id as roomid, a.*, a.category as category, a.addon as addon, c.service_name as servicename, d.package_name as packagename, b.fullname as therapistname from rooms_lounges
            left join (select * from job_orders where job_orders.status="Active") as a on rooms_lounges.id = a.room_no_form
            left join (select * from services) as c on c.id = a.service
            left join (select * from packages) as d on d.id = a.service
            left join (select * from therapists) as b on a.therapist_fullname = b.id where rooms_lounges.type ="room" order by rooms_lounges.id asc');

        $lounge = DB::select('
            select rooms_lounges.status as roomstatus, rooms_lounges.name as roomname, rooms_lounges.id as roomid, a.*, a.addon as addon, a.category as category, c.service_name as servicename, d.package_name as packagename, b.fullname as therapistname from rooms_lounges
            left join (select * from job_orders where job_orders.status="Active") as a on rooms_lounges.id = a.room_no_form
            left join (select * from services) as c on c.id = a.service
            left join (select * from packages) as d on d.id = a.service
            left join (select * from therapists) as b on a.therapist_fullname = b.id where rooms_lounges.type ="lounge" order by rooms_lounges.id asc');

        $service = Services::where('status', 'Active')->get();
        $packages = Packages::where('status', 'Active')->get();
        $client = Clients::all();

        $joborder = JobOrder::select('job_orders.*', 'therapists.fullname as therapistname', 'services.service_name as service_name', 'services.id', 'job_orders.addon as addon')->leftJoin('therapists', 'job_orders.therapist_fullname', '=', 'therapists.id')->leftJoin('services', 'job_orders.service', '=', 'services.id')->whereDate('job_orders.created_at', $formattedCurrentDay)->orderBy('job_orders.id', 'desc')->get();


        $jobOrderCount = JobOrder::orderBy('id', 'desc')->first();
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
            $cmds .= '0x0A';
            $cmds .= '0x0A';
            $cmds .= 'OUT:___________'.'  '.'Thera:____________';
            $cmds .= '0x0A';
            $cmds .= '0x0A';
            $cmds .= '0x0A';
            $cmds .= '0x0A';
            $cmds .= '0x0A';
            $cmds .= '0x0A';
            $cmds .= '0x0A';
            $cmds .= 'PLEASE PRESENT THIS TO YOUR';
            $cmds .= '0x0A';
            $cmds .= 'ATTENDING THERAPIST'; 
            $cmds .= '0x0A';
            $cmds .= '0x0A';
 
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
    		'category' => 'Single',
            'service' => $request->input('services'),
    		'addon' => $request->input('addon'),
    		'payment' => $request->input('payment'),
    		'care_of' => $request->input('care_of'),
            'gcno' => $request->input('gcno'),
    		'price' => $request->input('price'),
    		'status' => 'Active',
            $day => $request->input('commmission'),
            'created_at' => date('Y-m-d H:i:s', strtotime($request->input('date')))
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

        $date = Carbon::now()->format('Y-m-d H:i:s');

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

        $now = Carbon::now();
        $start = $now->startOfWeek(Carbon::FRIDAY);
        $end = $now->endOfWeek(Carbon::THURSDAY);
        $day = $start->format('N');
        $startDate = $now->startOfWeek(Carbon::FRIDAY)->format('Y-m-d');
        $endDate = $now->endOfWeek(Carbon::THURSDAY)->format('Y-m-d');
        $alltherapists = Therapist::where('status', 'Active')->where('basic', '!=', NULL)->get();


        $client = Clients::select('clients.*', 'job_orders.job_order', 'job_orders.client_fullname', 'job_orders.therapist_fullname', 'therapists.id', 'therapists.fullname as therafullname', 'job_orders.created_at as lastvisit')
                ->leftJoin('job_orders', 'clients.fullname', '=', 'job_orders.client_fullname')
                ->leftJoin('therapists', 'job_orders.therapist_fullname', '=', 'therapists.id')
                ->orderBy('job_orders.created_at', 'desc')
                ->get();

        return view('clients', compact('client', 'alltherapists', 'day'), ['day' => $day]);
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

        $now = Carbon::now();
        $start = $now->startOfWeek(Carbon::FRIDAY);
        $end = $now->endOfWeek(Carbon::THURSDAY);
        $day = $start->format('N');
        $startDate = $now->startOfWeek(Carbon::FRIDAY)->format('Y-m-d');
        $endDate = $now->endOfWeek(Carbon::THURSDAY)->format('Y-m-d');
        $alltherapists = Therapist::where('status', 'Active')->where('basic', '!=', NULL)->get();

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

        return view('gc', compact('services', 'gc', 'client', 'alltherapists', 'day'),['gcCount' => $gcCount, 'day' => $day]);
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

        $now = Carbon::now();
        $start = $now->startOfWeek(Carbon::FRIDAY);
        $end = $now->endOfWeek(Carbon::THURSDAY);
        $day = $start->format('N');
        $startDate = $now->startOfWeek(Carbon::FRIDAY)->format('Y-m-d');
        $endDate = $now->endOfWeek(Carbon::THURSDAY)->format('Y-m-d');

        $alltherapists = Therapist::where('status', 'Active')->where('basic', '!=', NULL)->get();

        $expenseCount = PettyExpense::orderBy('id', 'desc')->first();
        $expenses = PettyExpense::all();
        return view('expenses', compact('expenses', 'alltherapists', 'day'), ['expenseCount' => $expenseCount, 'day' => $day, 'startDate' => $startDate, 'endDate' => $endDate]);
    }

    public function f_expenses_filter(Request $request) {

        $now = Carbon::now();
        $start = $now->startOfWeek(Carbon::FRIDAY);
        $end = $now->endOfWeek(Carbon::THURSDAY);
        $day = $start->format('N');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $alltherapists = Therapist::where('status', 'Active')->where('basic', '!=', NULL)->get();
        
        $expenseCount = PettyExpense::orderBy('id', 'desc')->first();
        $expenses = PettyExpense::whereBetween('created_at', [$startDate, $endDate])->get();
        return view('expenses', compact('expenses', 'alltherapists', 'day'), ['expenseCount' => $expenseCount, 'day' => $day, 'startDate' => $startDate, 'endDate' => $endDate]);
    }

    public function attendance()
    {
        $now = Carbon::now();
        $startDate = $now->startOfWeek(Carbon::FRIDAY)->format('Y-m-d');
        $endDate = $now->endOfWeek(Carbon::THURSDAY)->format('Y-m-d');
        $day = Carbon::now()->format('N');
        // dd($day);
        $month = Carbon::now()->format('m');

        return view('attendance', ['day' => $day, 'month' => $month, 'startDate' => $startDate, 'endDate' => $endDate]);
    }

    public function checkpin($id)
    {
        $info = explode(',', $id);
        
        $validateUser = Therapist::where('id', $info[1])->where('pin', $info[2])->first();

        if($validateUser) {
            return response()->json($validateUser);
        } else {
            return false;
        }
    }

    public function timein($id, Request $request)
    {
        $info = explode(',', $id);

        $attendance = new Attendance;
        $attendance->user_id = $info[1];
        $attendance->time_in = Carbon::now();
        $attendance->day = $info[0];
        $attendance->save();

        return response()->json($attendance);
    }

    public function timeout($id, Request $request)
    {
        $info = explode(',', $id);

        $attendance = Attendance::where('user_id', $info[1])->orderBy('id', 'desc')->first();
        $data = array(
            'time_out' => Carbon::now()
        );

        $updateAttendance = Attendance::where('id', $attendance->id)->update($data);
        return response()->json($updateAttendance);
    }

    public function f_expense_store(Request $request)
    {
        $data = array(
            'ref_no' => $request->input('ref_no'),
            'therapist' => $request->input('therapist'),
            'category' => $request->input('category'),
            'particulars' => $request->input('particulars'),
            'value' => $request->input('value'),
            'created_at' => date('Y-m-d H:i:s', strtotime($request->input('date')))
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
        $alltherapists = Therapist::where('status', 'Active')->where('basic', '!=', NULL)->get();

        $payroll_therapist = DB::select('
            select a.created_at as created_at, b.id, b.fullname , COALESCE(b.basic,0) as basic, COALESCE(b.allowance,0) as allowance, COALESCE(b.lodging,0) as lodging, COALESCE(b.sss,0) as sss, COALESCE(b.phealth,0) as phealth, COALESCE(b.hdf,0) as hdf, sum(COALESCE(b.uniform,0) + COALESCE(b.fare,0) + COALESCE(b.others,0)) as others, 
            sum(COALESCE(a.day0,0) + COALESCE(a.day1,0) + COALESCE(a.day2,0) + COALESCE(a.day3,0) + COALESCE(a.day4,0) + COALESCE(a.day5,0) + COALESCE(a.day6,0)) as total, sum(COALESCE(a.day0,0)) as Fri, sum(COALESCE(a.day1,0)) as Sat, sum(COALESCE(a.day2,0)) as Sun, sum(COALESCE(a.day3,0)) as Mon, sum(COALESCE(a.day4,0)) as Tue, sum(COALESCE(a.day5,0)) as Wed, sum(COALESCE(a.day6,0)) as Thurs
            from job_orders a, therapists b
            where a.therapist_fullname=b.id
            and DATE_FORMAT(a.created_at, "%Y-%m-%d") BETWEEN DATE_FORMAT("'.$startDate.'", "%Y-%m-%d") AND DATE_FORMAT("'.$endDate.'", "%Y-%m-%d")
            group by b.fullname
            ');

        return view('payroll', compact('alltherapists', 'payroll_therapist', 'day'), ['startDate' => $startDate, 'endDate' => $endDate, 'day' => $day]);
    }

    public function f_payroll_filter(Request $request) {

        
        $now = Carbon::now();
        $start = $now->startOfWeek(Carbon::FRIDAY);
        $end = $now->endOfWeek(Carbon::THURSDAY);
        $day = $start->format('N');

        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $alltherapists = Therapist::where('status', 'Active')->where('basic', '!=', NULL)->get();

        $payroll_therapist = DB::select('
            select a.created_at as created_at, b.id, b.fullname , COALESCE(b.basic,0) as basic, COALESCE(b.allowance,0) as allowance, COALESCE(b.lodging,0) as lodging, COALESCE(b.sss,0) as sss, COALESCE(b.phealth,0) as phealth, COALESCE(b.hdf,0) as hdf, sum(COALESCE(b.uniform,0) + COALESCE(b.fare,0) + COALESCE(b.others,0)) as others, 
            sum(COALESCE(a.day0,0) + COALESCE(a.day1,0) + COALESCE(a.day2,0) + COALESCE(a.day3,0) + COALESCE(a.day4,0) + COALESCE(a.day5,0) + COALESCE(a.day6,0)) as total, sum(COALESCE(a.day0,0)) as Fri, sum(COALESCE(a.day1,0)) as Sat, sum(COALESCE(a.day2,0)) as Sun, sum(COALESCE(a.day3,0)) as Mon, sum(COALESCE(a.day4,0)) as Tue, sum(COALESCE(a.day5,0)) as Wed, sum(COALESCE(a.day6,0)) as Thurs
            from job_orders a, therapists b
            where a.therapist_fullname=b.id
            and DATE_FORMAT(a.created_at, "%Y-%m-%d") BETWEEN DATE_FORMAT("'.$startDate.'", "%Y-%m-%d") AND DATE_FORMAT("'.$endDate.'", "%Y-%m-%d")
            group by b.fullname
            ');

        $payroll_frontdesk = DB::select('
            select b.fullname, COALESCE(b.basic,0) as basic, COALESCE(b.allowance,0) as allowance, COALESCE(b.lodging,0) as lodging, COALESCE(b.sss,0) as sss, COALESCE(b.phealth,0) as phealth, COALESCE(b.hdf,0) as hdf, sum(COALESCE(b.uniform,0) + COALESCE(b.fare,0) + COALESCE(b.others,0)) as others, x.name as name, x.time_in as time_in, x.time_out as time_out, sum(x.day1) as day1, sum(x.day2) as day2, sum(x.day3) as day3, sum(x.day4) as day4, sum(x.day5) as day5, sum(x.day6) as day6, sum(x.day7) as day7
            from therapists b, attendances x
            where b.fullname = x.name
            and DATE_FORMAT(x.created_at, "%Y-%m-%d") BETWEEN DATE_FORMAT("'.$startDate.'", "%Y-%m-%d") AND DATE_FORMAT("'.$endDate.'", "%Y-%m-%d")
            group by b.fullname
            ');

        return view('payroll', compact('alltherapists', 'payroll_therapist', 'payroll_frontdesk', 'day'), ['startDate' => $startDate, 'endDate' => $endDate, 'day' => $day]);
    }

    public function sales_tally()
    {
        $day = Carbon::now()->format('Y-m-d');
        $gc = Giftcertificate::all();
        $job_orders = JobOrder::where('status', 'Done')->whereDate('created_at', Carbon::today())->get();
        $dailySales = DB::table('job_orders')
                    ->where('status', 'Done')
                    ->whereDate('created_at', Carbon::today())
                    ->sum('price');
        $dailySales += Giftcertificate::whereDate('created_at', Carbon::today())->sum('value');
        $dailyExpenses = PettyExpense::whereDate('created_at', Carbon::today())->sum('value');
        $alltherapists = Therapist::where('status', 'Active')->where('basic', '!=', NULL)->get();
        return view('sales', compact('job_orders', 'gc', 'alltherapists'),['day' => $day, 'dailySales' => $dailySales, 'dailyExpenses' => $dailyExpenses]);
    }

    public function st_filter(Request $request)
    {
        $day = $request->get('day');
        $gc = Giftcertificate::all();
        $job_orders = JobOrder::where('status', 'Done')->whereDate('created_at', $day)->get();
        $dailySales = DB::table('job_orders')
                    ->where('status', 'Done')
                    ->whereDate('created_at', $day)
                    ->sum('price');
        $dailySales += Giftcertificate::whereDate('created_at', $day)->sum('value');
        $dailyExpenses = PettyExpense::whereDate('created_at', $day)->sum('value');
        $alltherapists = Therapist::where('status', 'Active')->where('basic', '!=', NULL)->get();
        return view('sales', compact('job_orders', 'gc', 'alltherapists'),['day' => $day, 'dailySales' => $dailySales, 'dailyExpenses' => $dailyExpenses]);
    }
}
