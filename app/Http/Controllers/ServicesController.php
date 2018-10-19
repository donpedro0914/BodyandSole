<?php

namespace App\Http\Controllers;

use App\Services;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class ServicesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $services = Services::all();
        return view('admin.services', compact('services'));
    }

    public function store(Request $request)
    {
        $data = array(
            'service_name' => $request->input('service_name'),
            'labor_s' => $request->input('labor_s'),
            'labor_p' => $request->input('labor_p'),
            'charge' => $request->input('charge'),
            'status' => 'Active'
        );

        $services = Services::create($data);

        return response()->json($services);

    }

    public function edit($id, Request $request) {
        $services = Services::where('id', $id)->first();

        return view('admin.edit.services', ['services' => $services]);
    }

    public function update($id, Request $request) {

        $data = array(
            'service_name' => $request->input('service_name'),
            'labor_s' => $request->input('labor_s'),
            'labor_p' => $request->input('labor_p'),
            'charge' => $request->input('charge'),
            'status' => $request->input('status')
        );

        Services::where('id', $id)->update($data);

        $updateService = Services::where('id', $id)->first();
        return response()->json($updateService);
    }

}
