<?php

namespace App\Http\Controllers;

use App\JobOrder;
use App\Therapist;
use App\Giftcertificate;
use App\PettyExpense;
use App\Attendance;
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
        $day = Carbon::now()->format('Y-m-d');
        $gc = Giftcertificate::all();
        $job_orders = JobOrder::where('status', 'Done')->get();
        return view('admin.report.sales', compact('job_orders', 'gc'),['day' => $day]);
    }

    public function payroll_reports() {

        $now = Carbon::now();
        $start = $now->startOfWeek(Carbon::FRIDAY);
        $end = $now->endOfWeek(Carbon::THURSDAY);
        $day = $start->format('N');
        $startDate = $now->startOfWeek(Carbon::FRIDAY)->format('Y-m-d');
        $endDate = $now->endOfWeek(Carbon::THURSDAY)->format('Y-m-d');

        $payroll_therapist = DB::select('
            select a.created_at as created_at, b.id, b.fullname , COALESCE(b.basic,0) as basic, COALESCE(b.allowance,0) as allowance, COALESCE(b.lodging,0) as lodging, COALESCE(b.sss,0) as sss, COALESCE(b.phealth,0) as phealth, COALESCE(b.hdf,0) as hdf, sum(COALESCE(b.uniform,0) + COALESCE(b.fare,0) + COALESCE(b.others,0)) as others, 
            sum(COALESCE(a.day0,0) + COALESCE(a.day1,0) + COALESCE(a.day2,0) + COALESCE(a.day3,0) + COALESCE(a.day4,0) + COALESCE(a.day5,0) + COALESCE(a.day6,0)) as total, sum(COALESCE(a.day0,0)) as Fri, sum(COALESCE(a.day1,0)) as Sat, sum(COALESCE(a.day2,0)) as Sun, sum(COALESCE(a.day3,0)) as Mon, sum(COALESCE(a.day4,0)) as Tue, sum(COALESCE(a.day5,0)) as Wed, sum(COALESCE(a.day6,0)) as Thurs
            from job_orders a, therapists b
            where a.therapist_fullname=b.id
            and DATE_FORMAT(a.created_at, "%Y-%m-%d") BETWEEN DATE_FORMAT("'.$startDate.'", "%Y-%m-%d") AND DATE_FORMAT("'.$endDate.'", "%Y-%m-%d")
            group by b.fullname
            ');

        $payroll_frontdesk = DB::select('
            select b.id as id, b.fullname, COALESCE(b.basic,0) as basic, COALESCE(b.allowance,0) as allowance, COALESCE(b.lodging,0) as lodging, COALESCE(b.sss,0) as sss, COALESCE(b.phealth,0) as phealth, COALESCE(b.hdf,0) as hdf, sum(COALESCE(b.uniform,0) + COALESCE(b.fare,0) + COALESCE(b.others,0)) as others, x.name as name, x.time_in as time_in, x.time_out as time_out, sum(x.day1) as day1, sum(x.day2) as day2, sum(x.day3) as day3, sum(x.day4) as day4, sum(x.day5) as day5, sum(x.day6) as day6, sum(x.day7) as day7
            from therapists b, attendances x
            where b.fullname = x.name
            and DATE_FORMAT(x.created_at, "%Y-%m-%d") BETWEEN DATE_FORMAT("'.$startDate.'", "%Y-%m-%d") AND DATE_FORMAT("'.$endDate.'", "%Y-%m-%d")
            group by b.fullname
            ');

        return view('admin.report.payroll', compact('payroll_therapist', 'payroll_frontdesk'), ['startDate' => $startDate, 'endDate' => $endDate]);
    }

    public function weekly_commission_reports() {

        $now = Carbon::now();
        $start = $now->startOfWeek(Carbon::FRIDAY);
        $end = $now->endOfWeek(Carbon::THURSDAY);
        $day = $start->format('N');
        $startDate = $now->startOfWeek(Carbon::FRIDAY)->format('Y-m-d');
        $endDate = $now->endOfWeek(Carbon::THURSDAY)->format('Y-m-d');
        
        $commission = DB::select('
                select a.created_at as created_at, b.id, b.fullname, sum(COALESCE(a.day0,0)) as Sun, sum(COALESCE(a.day1,0)) as Mon, sum(COALESCE(a.day2,0)) as Tue, sum(COALESCE(a.day3,0)) as Wed, sum(COALESCE(a.day4,0)) as Thurs, sum(COALESCE(a.day5,0)) as Fri, sum(COALESCE(a.day6,0)) as Sat, sum(COALESCE(a.day0,0) + COALESCE(a.day1,0) + COALESCE(a.day2,0) + COALESCE(a.day3,0) + COALESCE(a.day4,0) + COALESCE(a.day5,0) + COALESCE(a.day6,0)) as total
                from job_orders a, therapists b
                where a.therapist_fullname = b.id
                and a.status = "DONE"
                and DATE_FORMAT(a.created_at, "%Y-%m-%d") BETWEEN DATE_FORMAT("'.$startDate.'", "%Y-%m-%d") AND DATE_FORMAT("'.$endDate.'", "%Y-%m-%d")
                group by b.fullname
                order by b.fullname asc');

        return view('admin.report.weekly_commission', compact('commission'),['startDate' => $startDate, 'endDate' => $endDate]);
    }

    public function expense_reports() {

        $now = Carbon::now();
        $start = $now->startOfWeek(Carbon::FRIDAY);
        $end = $now->endOfWeek(Carbon::THURSDAY);
        $day = $start->format('N');
        $startDate = $now->startOfWeek(Carbon::FRIDAY)->format('Y-m-d');
        $endDate = $now->endOfWeek(Carbon::THURSDAY)->format('Y-m-d');

        $expense = DB::select('
                select b.fullname , COALESCE(b.basic,0) as basic, COALESCE(b.lodging,0) as lodging, COALESCE(b.sss,0) as sss, COALESCE(b.phealth,0) as phealth, COALESCE(b.hdf,0) as hdf, COALESCE(b.allowance,0) as allowance, sum(COALESCE(b.uniform,0) + COALESCE(b.fare,0) + COALESCE(b.others,0)) as others,
                sum(COALESCE(a.day0,0) + COALESCE(a.day1,0) + COALESCE(a.day2,0) + COALESCE(a.day3,0) + COALESCE(a.day4,0) + COALESCE(a.day5,0) + COALESCE(a.day6,0)) as total
                from job_orders a, therapists b
                where a.therapist_fullname=b.id
                group by b.fullname
                union

                select b.fullname ,COALESCE(b.basic,0) as basic,COALESCE(b.lodging,0) as lodging, COALESCE(b.sss,0) as sss, COALESCE(b.phealth,0) as phealth, COALESCE(b.hdf,0) as hdf, COALESCE(b.allowance,0) as allowance, sum(COALESCE(b.uniform,0) + COALESCE(b.fare,0) + COALESCE(b.others,0)) as others, 0
                from job_orders a, therapists b
                where b.id not in (select distinct a.therapist_fullname from job_orders a)
                group by b.fullname');

        return view('admin.report.expense', compact('expense'), ['startDate' => $startDate, 'endDate' => $endDate]);

    }

    public function therapist_detailed_report($id) {

        $now = Carbon::now()->format('Y-m-d');
        $en = Carbon::parse($now);
        $start = $en->startOfWeek(Carbon::FRIDAY);
        $end = $en->endOfWeek(Carbon::THURSDAY);
        $currentDay = Carbon::now();
        $day = $currentDay->dayOfWeek;
        $startDate = $en->startOfWeek(Carbon::FRIDAY)->format('Y-m-d');
        $endDate = $en->endOfWeek(Carbon::THURSDAY)->format('Y-m-d');

        $therapistInfo = Therapist::where('id', $id)->first();

        $day1 = DB::select('
                select b.fullname, c.service_name, a.job_order, a.created_at, a.status, a.day5
                from job_orders a, therapists b, services c
                where a.therapist_fullname = b.id
                and a.service = c.id
                and b.id = "'.$id.'"
                and DATE_FORMAT(a.created_at, "%Y-%m-%d") BETWEEN DATE_FORMAT("'.$startDate.'", "%Y-%m-%d") AND DATE_FORMAT("'.$endDate.'", "%Y-%m-%d")
                and a.status = "Done"
                and a.day5 <> ""
                group by b.fullname, c.service_name, a.job_order, a.day5');

        $day2 = DB::select('
                select b.fullname, c.service_name, a.job_order, a.created_at, a.status, a.day6
                from job_orders a, therapists b, services c
                where a.therapist_fullname = b.id
                and a.service = c.id
                and b.id = "'.$id.'"
                and DATE_FORMAT(a.created_at, "%Y-%m-%d") BETWEEN DATE_FORMAT("'.$startDate.'", "%Y-%m-%d") AND DATE_FORMAT("'.$endDate.'", "%Y-%m-%d")
                and a.status = "Done"
                and a.day6 <> ""
                group by b.fullname, c.service_name, a.job_order, a.day6');

        $day3 = DB::select('
                select b.fullname, c.service_name, a.job_order, a.created_at, a.status, a.day0
                from job_orders a, therapists b, services c
                where a.therapist_fullname = b.id
                and a.service = c.id
                and b.id = "'.$id.'"
                and DATE_FORMAT(a.created_at, "%Y-%m-%d") BETWEEN DATE_FORMAT("'.$startDate.'", "%Y-%m-%d") AND DATE_FORMAT("'.$endDate.'", "%Y-%m-%d")
                and a.status = "Done"
                and a.day0 <> ""
                group by b.fullname, c.service_name, a.job_order, a.day0');

        $day4 = DB::select('
                select b.fullname, c.service_name, a.job_order, a.created_at, a.status, a.day1
                from job_orders a, therapists b, services c
                where a.therapist_fullname = b.id
                and a.service = c.id
                and b.id = "'.$id.'"
                and DATE_FORMAT(a.created_at, "%Y-%m-%d") BETWEEN DATE_FORMAT("'.$startDate.'", "%Y-%m-%d") AND DATE_FORMAT("'.$endDate.'", "%Y-%m-%d")
                and a.status = "Done"
                and a.day1 <> ""
                group by b.fullname, c.service_name, a.job_order, a.day1');

        $day5 = DB::select('
                select b.fullname, c.service_name, a.job_order, a.created_at, a.status, a.day2
                from job_orders a, therapists b, services c
                where a.therapist_fullname = b.id
                and a.service = c.id
                and b.id = "'.$id.'"
                and DATE_FORMAT(a.created_at, "%Y-%m-%d") BETWEEN DATE_FORMAT("'.$startDate.'", "%Y-%m-%d") AND DATE_FORMAT("'.$endDate.'", "%Y-%m-%d")
                and a.status = "Done"
                and a.day2 <> ""
                group by b.fullname, c.service_name, a.job_order, a.day2');

        $day6 = DB::select('
                select b.fullname, c.service_name, a.job_order, a.created_at, a.status, a.day3
                from job_orders a, therapists b, services c
                where a.therapist_fullname = b.id
                and a.service = c.id
                and b.id = "'.$id.'"
                and DATE_FORMAT(a.created_at, "%Y-%m-%d") BETWEEN DATE_FORMAT("'.$startDate.'", "%Y-%m-%d") AND DATE_FORMAT("'.$endDate.'", "%Y-%m-%d")
                and a.status = "Done"
                and a.day3 <> ""
                group by b.fullname, c.service_name, a.job_order, a.day3');

        $day7 = DB::select('
                select b.fullname, c.service_name, a.job_order, a.created_at, a.status, a.day4
                from job_orders a, therapists b, services c
                where a.therapist_fullname = b.id
                and a.service = c.id
                and b.id = "'.$id.'"
                and DATE_FORMAT(a.created_at, "%Y-%m-%d") BETWEEN DATE_FORMAT("'.$startDate.'", "%Y-%m-%d") AND DATE_FORMAT("'.$endDate.'", "%Y-%m-%d")
                and a.status = "Done"
                and a.day4 <> ""
                group by b.fullname, c.service_name, a.job_order, a.day4');

        return view('admin.report.therapist_detailed_report',compact('therapistInfo', 'day1', 'day2', 'day3', 'day4', 'day5', 'day6', 'day7'), ['startDate' => $startDate, 'endDate' => $endDate]);
    }

    public function weekly_attendance_reports() {

        $now = Carbon::now()->format('Y-m-d');
        $en = Carbon::parse($now);
        $start = $en->startOfWeek(Carbon::FRIDAY);
        $end = $en->endOfWeek(Carbon::THURSDAY);
        $currentDay = Carbon::now();
        $day = $currentDay->dayOfWeek;
        $startDate = $en->startOfWeek(Carbon::FRIDAY)->format('Y-m-d');
        $endDate = $en->endOfWeek(Carbon::THURSDAY)->format('Y-m-d');

        $attendance = DB::select('select name, time_in, time_out,
            sum(day1) as day1, 
            sum(day2) as day2, 
            sum(day3) as day3, 
            sum(day4) as day4, 
            sum(day5) as day5, 
            sum(day6) as day6, 
            sum(day7) as day7
            from attendances
            where DATE_FORMAT(created_at, "%Y-%m-%d") BETWEEN DATE_FORMAT("'.$startDate.'", "%Y-%m-%d") AND DATE_FORMAT("'.$endDate.'", "%Y-%m-%d")
            group by name');

        return view('admin.report.weekly_attendance', compact('attendance'), ['startDate' => $startDate, 'endDate' => $endDate]);
    }

    public function wcr_filter(Request $request) {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $filter_startDate = $request->input('startDate');
        $filter_endDate = $request->input('endDate');
        
        $commission = DB::select('
                select a.created_at as created_at, b.id, b.fullname, sum(COALESCE(a.day0,0)) as Sun, sum(COALESCE(a.day1,0)) as Mon, sum(COALESCE(a.day2,0)) as Tue, sum(COALESCE(a.day3,0)) as Wed, sum(COALESCE(a.day4,0)) as Thurs, sum(COALESCE(a.day5,0)) as Fri, sum(COALESCE(a.day6,0)) as Sat, sum(COALESCE(a.day0,0) + COALESCE(a.day1,0) + COALESCE(a.day2,0) + COALESCE(a.day3,0) + COALESCE(a.day4,0) + COALESCE(a.day5,0) + COALESCE(a.day6,0)) as total
                from job_orders a, therapists b
                where a.therapist_fullname = b.id
                and a.status = "DONE"
                and DATE_FORMAT(a.created_at, "%Y-%m-%d") BETWEEN DATE_FORMAT("'.$filter_startDate.'", "%Y-%m-%d") AND DATE_FORMAT("'.$filter_endDate.'", "%Y-%m-%d")
                group by b.fullname
                order by b.fullname asc');

        return view('admin.report.weekly_commission', compact('commission'),['startDate' => $startDate, 'endDate' => $endDate]);
    }

    public function payroll_filter(Request $request) {
        
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

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

        return view('admin.report.payroll', compact('payroll_therapist', 'payroll_frontdesk'), ['startDate' => $startDate, 'endDate' => $endDate]);
    }

    public function daily_commissions()
    {
        $day = Carbon::now()->format('Y-m-d');
        $job_orders = JobOrder::select('job_orders.*', 'therapists.fullname as fullname', 'services.service_name as service_name', 'services.labor_s as labor')->leftJoin('therapists', 'job_orders.therapist_fullname', '=', 'therapists.id')->leftJoin('services', 'job_orders.service', '=', 'services.id')->where('job_orders.status', 'Done')->get();
        return view('admin.report.daily_commissions', compact('job_orders'),['day' => $day]);
    }

    public function periodic_sales()
    {
        $periodic_sales = DB::select('
        select a.price as price, b.value as value, a.created_at as create_date
        from job_orders a, petty_expenses b
        where DATE_FORMAT(a.created_at, "%Y-%m-%d") = DATE_FORMAT(b.created_at, "%Y-%m-%d")
        group by create_date');
        return view('admin.report.periodic_sales', compact('periodic_sales'));
    }
    
}
