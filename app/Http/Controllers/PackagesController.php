<?php

namespace App\Http\Controllers;

use App\Packages;
use App\Services;
use DB;
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
        $package = Packages::all();
        return view('admin.packages', compact('package'));
    }

    public function add_page() {

        $service = Services::where('status', 'Active')->get();
        return view('admin.addpackage', compact('service'));
    }

    public function ajaxService(Request $request) {

        $service = Services::whereIn('id', $request->input('id'))->get();
        return response()->json($service);

    }

    public function store(Request $request)
    {
        $data = array(
            'package_name' => $request->input('package_name'),
            'services' => $request->input('service'),
            'price' => $request->input('price'),
            'labor' => $request->input('labor'),
            'status' => 'Active'
        );

        $package = Packages::create($data);
        return back();

    }

    public function edit(Request $request, $id)
    {
        $packages = Packages::where('id', $id)->first();
        $services = Services::pluck('service_name', 'id');

        return view('admin.edit.packages', compact('services', 'selected'),['packages' => $packages]);
    }

    public function getServices(Request $request) {

        // dd(request('services'));
        $id = request('services');
        // $service = Services::whereIn('id', request('services'))->get();
        $service = DB::select('select * from services where id IN ('.$id.')');
        return response()->json($service);

    }

    public function delete($id)
    {
        $package = Packages::find($id)->delete();

        return response()->json($package);

    }
}
