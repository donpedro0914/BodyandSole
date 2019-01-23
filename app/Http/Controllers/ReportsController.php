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
        $job_orders = JobOrder::where('status', 'Done')->whereDate('created_at', Carbon::today())->get();
        $dailySales = DB::table('job_orders')
                    ->where('status', 'Done')
                    ->whereDate('created_at', Carbon::today())
                    ->sum('price');
        $dailySales += Giftcertificate::whereDate('created_at', Carbon::today())->sum('value');
        $dailyExpenses = PettyExpense::whereDate('created_at', Carbon::today())->sum('value');
        return view('admin.report.sales', compact('job_orders', 'gc'),['day' => $day, 'dailySales' => $dailySales, 'dailyExpenses' => $dailyExpenses]);
    }

    public function ds_filter(Request $request) {
        $day = $request->get('day');
        $gc = Giftcertificate::all();
        $job_orders = JobOrder::where('status', 'Done')->whereDate('created_at', $day)->get();
        $dailySales = DB::table('job_orders')
                    ->where('status', 'Done')
                    ->whereDate('created_at', $day)
                    ->sum('price');
                    $dailySales += Giftcertificate::whereDate('created_at', $day)->sum('value');
        $dailyExpenses = PettyExpense::whereDate('created_at', $day)->sum('value');
        return view('admin.report.sales', compact('job_orders', 'gc'),['day' => $day, 'dailySales' => $dailySales, 'dailyExpenses' => $dailyExpenses]);
    }

    public function payroll_reports() {

        $now = Carbon::now();
        $start = $now->startOfWeek(Carbon::FRIDAY);
        $end = $now->endOfWeek(Carbon::THURSDAY);
        $day = $start->format('N');
        $startDate = $now->startOfWeek(Carbon::FRIDAY)->format('Y-m-d');
        $endDate = $now->endOfWeek(Carbon::THURSDAY)->format('Y-m-d');

        $payroll_therapist = DB::select('
            select a.created_at as created_at, b.id, b.fullname , COALESCE(b.basic,0) as basic, COALESCE(b.allowance,0) as allowance, COALESCE(b.lodging,0) as lodging, COALESCE(b.sss,0) as sss, COALESCE(b.phealth,0) as phealth, COALESCE(b.hdf,0) as hdf, COALESCE(b.uniform,0) as uniform, COALESCE(b.fare,0) as fare, COALESCE(b.others,0) as others, 
            sum(COALESCE(a.day0,0) + COALESCE(a.day1,0) + COALESCE(a.day2,0) + COALESCE(a.day3,0) + COALESCE(a.day4,0) + COALESCE(a.day5,0) + COALESCE(a.day6,0)) as total, sum(COALESCE(a.day0,0)) as Fri, sum(COALESCE(a.day1,0)) as Sat, sum(COALESCE(a.day2,0)) as Sun, sum(COALESCE(a.day3,0)) as Mon, sum(COALESCE(a.day4,0)) as Tue, sum(COALESCE(a.day5,0)) as Wed, sum(COALESCE(a.day6,0)) as Thurs
            from job_orders a, therapists b
            where a.therapist_fullname=b.id
            and DATE_FORMAT(a.created_at, "%Y-%m-%d") BETWEEN DATE_FORMAT("'.$startDate.'", "%Y-%m-%d") AND DATE_FORMAT("'.$endDate.'", "%Y-%m-%d")
            group by b.fullname
            ');

        return view('admin.report.payroll', compact('payroll_therapist'), ['startDate' => $startDate, 'endDate' => $endDate, 'day' => $day]);
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

    public function therapist_detailed_report(Request $request, $id) {

        $now = Carbon::now()->format('Y-m-d');
        $en = Carbon::parse($now);
        $start = $en->startOfWeek(Carbon::FRIDAY);
        $end = $en->endOfWeek(Carbon::THURSDAY);
        $currentDay = Carbon::now();
        $day = $currentDay->dayOfWeek;
        $startDate = $en->startOfWeek(Carbon::FRIDAY)->format('Y-m-d');
        $endDate = $en->endOfWeek(Carbon::THURSDAY)->format('Y-m-d');

        $therapistInfo = Therapist::where('id', $id)->first();

        $day1 = JobOrder::select('job_orders.therapist_fullname as fullname', 'job_orders.addon as addon', 'job_orders.service as service', 'job_orders.day5 as day5', 'services.service_name as service_name')->leftJoin('services', 'job_orders.service', '=', 'services.id')->where('job_orders.therapist_fullname', $id)->where('job_orders.day5', '!=', NULL)->where('job_orders.status', 'Done')->whereBetween('job_orders.created_at', [$startDate, $endDate])->get();

        $day2 = JobOrder::select('job_orders.therapist_fullname as fullname', 'job_orders.addon as addon', 'job_orders.service as service', 'job_orders.day6 as day6', 'services.service_name as service_name')->leftJoin('services', 'job_orders.service', '=', 'services.id')->where('job_orders.therapist_fullname', $id)->where('job_orders.day6', '!=', NULL)->where('job_orders.status', 'Done')->whereBetween('job_orders.created_at', [$startDate, $endDate])->get();

        $day3 = JobOrder::select('job_orders.therapist_fullname as fullname', 'job_orders.addon as addon', 'job_orders.service as service', 'job_orders.day0 as day0', 'services.service_name as service_name')->leftJoin('services', 'job_orders.service', '=', 'services.id')->where('job_orders.therapist_fullname', $id)->where('job_orders.day0', '!=', NULL)->where('job_orders.status', 'Done')->whereBetween('job_orders.created_at', [$startDate, $endDate])->get();

        $day4 = JobOrder::select('job_orders.therapist_fullname as fullname', 'job_orders.addon as addon', 'job_orders.service as service', 'job_orders.day1 as day1', 'services.service_name as service_name')->leftJoin('services', 'job_orders.service', '=', 'services.id')->where('job_orders.therapist_fullname', $id)->where('job_orders.day1', '!=', NULL)->where('job_orders.status', 'Done')->whereBetween('job_orders.created_at', [$startDate, $endDate])->get();

        $day5 = JobOrder::select('job_orders.therapist_fullname as fullname', 'job_orders.addon as addon', 'job_orders.service as service', 'job_orders.day2 as day2', 'services.service_name as service_name')->leftJoin('services', 'job_orders.service', '=', 'services.id')->where('job_orders.therapist_fullname', $id)->where('job_orders.day2', '!=', NULL)->where('job_orders.status', 'Done')->whereBetween('job_orders.created_at', [$startDate, $endDate])->get();

        $day6 = JobOrder::select('job_orders.therapist_fullname as fullname', 'job_orders.addon as addon', 'job_orders.service as service', 'job_orders.day3 as day3', 'services.service_name as service_name')->leftJoin('services', 'job_orders.service', '=', 'services.id')->where('job_orders.therapist_fullname', $id)->where('job_orders.day3', '!=', NULL)->where('job_orders.status', 'Done')->whereBetween('job_orders.created_at', [$startDate, $endDate])->get();

        $day7 = JobOrder::select('job_orders.therapist_fullname as fullname', 'job_orders.addon as addon', 'job_orders.service as service', 'job_orders.day4 as day4', 'services.service_name as service_name')->leftJoin('services', 'job_orders.service', '=', 'services.id')->where('job_orders.therapist_fullname', $id)->where('job_orders.day4', '!=', NULL)->where('job_orders.status', 'Done')->whereBetween('job_orders.created_at', [$startDate, $endDate])->get();

        return view('admin.report.therapist_detailed_report',compact('therapistInfo', 'day1', 'day2', 'day3', 'day4', 'day5', 'day6', 'day7'), ['startDate' => $startDate, 'endDate' => $endDate]);
    }

    public function therapist_detailed_report_filtered(Request $request, $id) {

        $startDate = $request->get('startDate');
        $endDate = $request->get('endDate');

        $therapistInfo = Therapist::where('id', $id)->first();

        $day1 = JobOrder::select('job_orders.therapist_fullname as fullname', 'job_orders.addon as addon', 'job_orders.service as service', 'job_orders.day5 as day5', 'services.service_name as service_name')->leftJoin('services', 'job_orders.service', '=', 'services.id')->where('job_orders.therapist_fullname', $id)->where('job_orders.day5', '!=', NULL)->where('job_orders.status', 'Done')->whereBetween('job_orders.created_at', [$startDate, $endDate])->get();

        $day2 = JobOrder::select('job_orders.therapist_fullname as fullname', 'job_orders.addon as addon', 'job_orders.service as service', 'job_orders.day6 as day6', 'services.service_name as service_name')->leftJoin('services', 'job_orders.service', '=', 'services.id')->where('job_orders.therapist_fullname', $id)->where('job_orders.day6', '!=', NULL)->where('job_orders.status', 'Done')->whereBetween('job_orders.created_at', [$startDate, $endDate])->get();

        $day3 = JobOrder::select('job_orders.therapist_fullname as fullname', 'job_orders.addon as addon', 'job_orders.service as service', 'job_orders.day0 as day0', 'services.service_name as service_name')->leftJoin('services', 'job_orders.service', '=', 'services.id')->where('job_orders.therapist_fullname', $id)->where('job_orders.day0', '!=', NULL)->where('job_orders.status', 'Done')->whereBetween('job_orders.created_at', [$startDate, $endDate])->get();

        $day4 = JobOrder::select('job_orders.therapist_fullname as fullname', 'job_orders.addon as addon', 'job_orders.service as service', 'job_orders.day1 as day1', 'services.service_name as service_name')->leftJoin('services', 'job_orders.service', '=', 'services.id')->where('job_orders.therapist_fullname', $id)->where('job_orders.day1', '!=', NULL)->where('job_orders.status', 'Done')->whereBetween('job_orders.created_at', [$startDate, $endDate])->get();

        $day5 = JobOrder::select('job_orders.therapist_fullname as fullname', 'job_orders.addon as addon', 'job_orders.service as service', 'job_orders.day2 as day2', 'services.service_name as service_name')->leftJoin('services', 'job_orders.service', '=', 'services.id')->where('job_orders.therapist_fullname', $id)->where('job_orders.day2', '!=', NULL)->where('job_orders.status', 'Done')->whereBetween('job_orders.created_at', [$startDate, $endDate])->get();

        $day6 = JobOrder::select('job_orders.therapist_fullname as fullname', 'job_orders.addon as addon', 'job_orders.service as service', 'job_orders.day3 as day3', 'services.service_name as service_name')->leftJoin('services', 'job_orders.service', '=', 'services.id')->where('job_orders.therapist_fullname', $id)->where('job_orders.day3', '!=', NULL)->where('job_orders.status', 'Done')->whereBetween('job_orders.created_at', [$startDate, $endDate])->get();

        $day7 = JobOrder::select('job_orders.therapist_fullname as fullname', 'job_orders.addon as addon', 'job_orders.service as service', 'job_orders.day4 as day4', 'services.service_name as service_name')->leftJoin('services', 'job_orders.service', '=', 'services.id')->where('job_orders.therapist_fullname', $id)->where('job_orders.day4', '!=', NULL)->where('job_orders.status', 'Done')->whereBetween('job_orders.created_at', [$startDate, $endDate])->get();

        return view('admin.report.therapist_detailed_report',compact('therapistInfo', 'day1', 'day2', 'day3', 'day4', 'day5', 'day6', 'day7'), ['startDate' => $startDate, 'endDate' => $endDate]);
    }

    public function weekly_attendance_reports() {

        $now = Carbon::now();
        $startDate = $now->startOfWeek(Carbon::FRIDAY)->format('Y-m-d');
        $endDate = $now->endOfWeek(Carbon::THURSDAY)->format('Y-m-d');
        $day = Carbon::now()->format('N');

        return view('admin.report.weekly_attendance', ['startDate' => $startDate, 'endDate' => $endDate, 'day' => $day]);
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

        $now = Carbon::now();
        $start = $now->startOfWeek(Carbon::FRIDAY);
        $end = $now->endOfWeek(Carbon::THURSDAY);
        $day = $start->format('N');

        $payroll_therapist = DB::select('
            select a.created_at as created_at, b.id, b.fullname , COALESCE(b.basic,0) as basic, COALESCE(b.allowance,0) as allowance, COALESCE(b.lodging,0) as lodging, COALESCE(b.sss,0) as sss, COALESCE(b.phealth,0) as phealth, COALESCE(b.hdf,0) as hdf, COALESCE(b.uniform,0) as uniform, COALESCE(b.fare,0) as fare, COALESCE(b.others,0) as others, 
            sum(COALESCE(a.day0,0) + COALESCE(a.day1,0) + COALESCE(a.day2,0) + COALESCE(a.day3,0) + COALESCE(a.day4,0) + COALESCE(a.day5,0) + COALESCE(a.day6,0)) as total, sum(COALESCE(a.day0,0)) as Fri, sum(COALESCE(a.day1,0)) as Sat, sum(COALESCE(a.day2,0)) as Sun, sum(COALESCE(a.day3,0)) as Mon, sum(COALESCE(a.day4,0)) as Tue, sum(COALESCE(a.day5,0)) as Wed, sum(COALESCE(a.day6,0)) as Thurs
            from job_orders a, therapists b
            where a.therapist_fullname=b.id
            and DATE_FORMAT(a.created_at, "%Y-%m-%d") BETWEEN DATE_FORMAT("'.$startDate.'", "%Y-%m-%d") AND DATE_FORMAT("'.$endDate.'", "%Y-%m-%d")
            group by b.fullname
            ');

        return view('admin.report.payroll', compact('payroll_therapist'), ['startDate' => $startDate, 'endDate' => $endDate, 'day' => $day]);
    }

    public function daily_commissions()
    {
        $day = Carbon::now()->format('Y-m-d');
        $job_orders = JobOrder::select('job_orders.*', 'therapists.fullname as fullname', 'services.service_name as service_name')->leftJoin('therapists', 'job_orders.therapist_fullname', '=', 'therapists.id')->leftJoin('services', 'job_orders.service', '=', 'services.id')->where('job_orders.status', 'Done')->get();
        return view('admin.report.daily_commissions', compact('job_orders'),['day' => $day]);
    }

    public function periodic_sales()
    {

        $now = Carbon::now()->format('Y-m-d');
        $en = Carbon::parse($now);
        $start = $en->startOfWeek(Carbon::FRIDAY);
        $end = $en->endOfWeek(Carbon::THURSDAY);
        $currentDay = Carbon::now();
        $startDate = $en->startOfWeek(Carbon::FRIDAY)->format('Y-m-d');
        $endDate = $en->endOfWeek(Carbon::THURSDAY)->format('Y-m-d');
        $day = Carbon::now()->format('Y-m-d');

        $periodic_sales = DB::select('select date, sum(sales) as sales, sum(expenses) as expenses, sum(gc) as gc
        from ((select date(created_at) as date, sum(price) as sales, 0 as expenses, 0 as gc
               from job_orders
               where DATE_FORMAT(created_at, "%Y-%m-%d") BETWEEN DATE_FORMAT("'.$startDate.'", "%Y-%m-%d") AND DATE_FORMAT("'.$endDate.'", "%Y-%m-%d")
               group by date(created_at)
              ) union all
              (select date(created_at) as date, 0 as sales, sum(value) as expenses, 0 as gc
               from petty_expenses
               where DATE_FORMAT(created_at, "%Y-%m-%d") BETWEEN DATE_FORMAT("'.$startDate.'", "%Y-%m-%d") AND DATE_FORMAT("'.$endDate.'", "%Y-%m-%d")
               group by date(created_at)
              ) union all
              (select date(created_at) as date, 0 as sales, 0 as expenses, sum(value) as gc
              from giftcertificates
              where DATE_FORMAT(created_at, "%Y-%m-%d") BETWEEN DATE_FORMAT("'.$startDate.'", "%Y-%m-%d") AND DATE_FORMAT("'.$endDate.'", "%Y-%m-%d")
              group by date(created_at)
              )
             ) t
        group by date');
        return view('admin.report.periodic_sales', compact('periodic_sales'), ['day' => $day, 'startDate' => $startDate, 'endDate' => $endDate]);
    }

    public function ps_filter(Request $request)
    {
        
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $periodic_sales = DB::select('select date, sum(sales) as sales, sum(expenses) as expenses, sum(gc) as gc
        from ((select date(created_at) as date, sum(price) as sales, 0 as expenses, 0 as gc
               from job_orders
               where DATE_FORMAT(created_at, "%Y-%m-%d") BETWEEN DATE_FORMAT("'.$startDate.'", "%Y-%m-%d") AND DATE_FORMAT("'.$endDate.'", "%Y-%m-%d")
               group by date(created_at)
              ) union all
              (select date(created_at) as date, 0 as sales, sum(value) as expenses, 0 as gc
               from petty_expenses
               where DATE_FORMAT(created_at, "%Y-%m-%d") BETWEEN DATE_FORMAT("'.$startDate.'", "%Y-%m-%d") AND DATE_FORMAT("'.$endDate.'", "%Y-%m-%d")
               group by date(created_at)
              ) union all
              (select date(created_at) as date, 0 as sales, 0 as expenses, sum(value) as gc
              from giftcertificates
              where DATE_FORMAT(created_at, "%Y-%m-%d") BETWEEN DATE_FORMAT("'.$startDate.'", "%Y-%m-%d") AND DATE_FORMAT("'.$endDate.'", "%Y-%m-%d")
              group by date(created_at)
              )
             ) t
        group by date');
        return view('admin.report.periodic_sales', compact('periodic_sales'), ['startDate' => $startDate, 'endDate' => $endDate]);

    }
    
}
