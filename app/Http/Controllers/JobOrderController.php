<?php

namespace App\Http\Controllers;

use App\JobOrder;
use DB;
use Illuminate\Http\Request;

class JobOrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $joborder = JobOrder::select('job_orders.*', 'therapists.fullname as therapistname')->leftJoin('therapists', 'job_orders.therapist_fullname', '=', 'therapists.id')->orderBy('job_orders.id', 'desc')->get();

        return view('admin.job_order', compact('joborder'));
    }

}
