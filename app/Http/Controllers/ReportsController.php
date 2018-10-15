<?php

namespace App\Http\Controllers;

use App\Reports;
use Illuminate\Http\Request;

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
        return view('admin.report.weekly_commission');
    }
    
}
