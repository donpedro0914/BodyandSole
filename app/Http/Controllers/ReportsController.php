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

        $now = Carbon::now();
        $start = $now->startOfWeek(Carbon::FRIDAY);
        $end = $now->endOfWeek(Carbon::THURSDAY);
        $day = $start->format('N');
        $startDate = $now->startOfWeek(Carbon::FRIDAY)->format('Y-m-d');
        $endDate = $now->endOfWeek(Carbon::THURSDAY)->format('Y-m-d');

        $payroll = DB::select('
                select therapists.fullname, COALESCE(therapists.basic,0) as basic, COALESCE(therapists.allowance,0) as allowance, sum(COALESCE(job_orders.day0,0) + COALESCE(job_orders.day1,0) + COALESCE(job_orders.day2,0) + COALESCE(job_orders.day3,0) + COALESCE(job_orders.day4,0) + COALESCE(job_orders.day5,0) + COALESCE(job_orders.day6,0)) as total
                from therapists
                left join job_orders on therapists.id = job_orders.therapist_fullname
                group by therapists.fullname');

        return view('admin.report.payroll', compact('payroll'), ['startDate' => $startDate, 'endDate' => $endDate]);
    }

    public function weekly_commission_reports() {

        $now = Carbon::now();
        $start = $now->startOfWeek(Carbon::FRIDAY);
        $end = $now->endOfWeek(Carbon::THURSDAY);
        $day = $start->format('N');
        $startDate = $now->startOfWeek(Carbon::FRIDAY)->format('Y-m-d');
        $endDate = $now->endOfWeek(Carbon::THURSDAY)->format('Y-m-d');
        
        $commission = DB::select('
                select b.fullname, sum(COALESCE(a.day0,0)) as Fri, sum(COALESCE(a.day1,0)) as Sat, sum(COALESCE(a.day2,0)) as Sun, sum(COALESCE(a.day3,0)) as Mon, sum(COALESCE(a.day4,0)) as Tue, sum(COALESCE(a.day5,0)) as Wed, sum(COALESCE(a.day6,0)) as Thurs, sum(COALESCE(a.day0,0) + COALESCE(a.day1,0) + COALESCE(a.day2,0) + COALESCE(a.day3,0) + COALESCE(a.day4,0) + COALESCE(a.day5,0) + COALESCE(a.day6,0)) as total
                from job_orders a, therapists b
                where a.therapist_fullname = b.id
                and a.status = "DONE"
                and (a.created_at BETWEEN "'.$startDate.'" AND "'.$endDate.'")
                group by b.fullname
                order by b.fullname asc');

        // $commission = DB::select('select a.*, b.fullname, b.id
        //     from job_orders a, therapists b
        //     where a.therapist_fullname = b.id
        //     and a.status = "Done"
        //     and (a.created_at BETWEEN "'.$startDate.'" AND "'.$endDate.'")
        //     group by b.fullname');

        return view('admin.report.weekly_commission', compact('commission'),['startDate' => $startDate, 'endDate' => $endDate]);
    }

    public function expense_reports() {

        $now = Carbon::now();
        $start = $now->startOfWeek(Carbon::FRIDAY);
        $end = $now->endOfWeek(Carbon::THURSDAY);
        $day = $start->format('N');
        $startDate = $now->startOfWeek(Carbon::FRIDAY)->format('Y-m-d');
        $endDate = $now->endOfWeek(Carbon::THURSDAY)->format('Y-m-d');

        $expense = DB::select('select therapists.fullname, COALESCE(therapists.lodging,0) as lodging, COALESCE(therapists.sss,0) as sss, COALESCE(therapists.phealth,0) as phealth, COALESCE(therapists.hdf,0) as hdf, COALESCE(therapists.allowance,0) as allowance, sum(COALESCE(therapists.uniform,0) + COALESCE(therapists.fare,0) + COALESCE(therapists.others,0)) as others,  sum(COALESCE(job_orders.day0,0) + COALESCE(job_orders.day1,0) + COALESCE(job_orders.day2,0) + COALESCE(job_orders.day3,0) + COALESCE(job_orders.day4,0) + COALESCE(job_orders.day5,0) + COALESCE(job_orders.day6,0)) as total
            from therapists
            left join job_orders on therapists.id = job_orders.therapist_fullname
            group by therapists.fullname');

        return view('admin.report.expense', compact('expense'), ['startDate' => $startDate, 'endDate' => $endDate]);

    }
    
}
