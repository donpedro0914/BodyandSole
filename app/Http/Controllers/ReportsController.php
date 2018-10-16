<?php

namespace App\Http\Controllers;

use App\JobOrder;
use App\Therapist;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class ReportsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function sales_reports() {
        return view('admin.report.sales');
    }

    public function payroll_reports() {
        return view('admin.report.payroll');
    }

    public function weekly_commission_reports() {

        $now = Carbon::now();
        $start = $now->startOfWeek(Carbon::FRIDAY);
        $end = $now->endOfWeek(Carbon::THURSDAY);
        $day = $start->format('N');
        $startDate = $now->startOfWeek(Carbon::FRIDAY)->format('Y-m-d');
        $endDate = $now->endOfWeek(Carbon::THURSDAY)->format('Y-m-d');
        
        $commission = JobOrder::select('therapists.*', 'job_orders.*')
                    ->leftJoin('therapists', 'job_orders.therapist_fullname', '=', 'therapists.id')
                    ->where('job_orders.status', 'Done')
                    ->groupBy('job_orders.therapist_fullname')
                    ->get();

        // $commission = DB::select('select a.fullname, b.status, DATE_FORMAT(b.created_at, "%M %d %Y") as mydate, sum(c.labor_s) as labor_s
        //     from therapists a, job_orders b, services c where a.id = b.therapist_fullname
        //     and b.service = c.id
        //     and b.status = "Done"
        //     group by a.fullname, mydate, labor_s');

        return view('admin.report.weekly_commission', compact('commission'),['startDate' => $startDate, 'endDate' => $endDate]);
    }
    
}
