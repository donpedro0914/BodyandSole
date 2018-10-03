<?php

namespace App\Http\Controllers;

use App\Packages;
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

        return view('admin.addpackage');
    }

    public function store(Request $request)
    {
        //
    }
}
