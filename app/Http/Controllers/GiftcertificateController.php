<?php

namespace App\Http\Controllers;

use App\Giftcertificate;
use App\Services;
use DB;
use Illuminate\Http\Request;

class GiftcertificateController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $gc = Giftcertificate::select('giftcertificates.*', 'services.service_name')
        ->leftJoin('services', 'services.id', '=', 'giftcertificates.service')
        ->get();
        $services = Services::where('status', 'Active')->get();
        return view('admin.gc', compact('services', 'gc'));
    }

    public function store(Request $request) {
        $data = array(
            'gc_no' => $request->input('gc_no'),
            'purchased_by' => $request->input('purchased_by'),
            'service' => $request->input('service'),
            'value' => $request->input('value'),
            'use' => $request->input('use'),
            'date_issued' => $request->input('date_issued'),
            'expiry_date' => $request->input('expiry_date'),
            'status' => 'Active'
        );

        $gcAdd = Giftcertificate::create($data);
        $gc = Giftcertificate::where('id', $gcAdd->id)->first();
        return response()->json($gc);


    }

    public function checker(Request $request) {
        $checkgc = Giftcertificate::where('gc_no', request('gc_no'))->first();

        if($checkgc) {
            return response()->json($checkgc);
        }        
    }
}
