<?php

namespace App\Http\Controllers;

use App\Packages;
use App\Services;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class PackagesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.packages');
    }

    public function add_page() {

        $service = Services::where('status', '0')->get();
        return view('admin.addpackage', compact('service'));
    }

    public function ajaxService(Request $request) {

        $service = Services::whereIn('id', request('id'))->get();
        return response()->json($service);

    }

    public function store(Request $request)
    {
        //
    }
}
