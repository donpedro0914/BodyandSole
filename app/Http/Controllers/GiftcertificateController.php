<?php

namespace App\Http\Controllers;

use App\Giftcertificate;
use App\Services;
use App\JobOrder;
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

        $gc = DB::select('select t.*, COALESCE(a.gcount,0) gcounts, service_name
            from giftcertificates t
            left join (
                select gcno, status, count(*) gcount
                from job_orders
                WHERE status = "Done"
                group by gcno
            ) a on t.gc_no = a.gcno
            left join (
                select id, service_name
                from services
            ) b on t.service = b.id');
        $services = Services::where('status', 'Active')->get();
        $gcCount = Giftcertificate::count();
        return view('admin.gc', compact('services', 'gc'), ['gcCount' => $gcCount]);
    }

    public function store(Request $request) {
        $data = array(
            'gc_no' => $request->input('gc_no'),
            'ref_no' => $request->input('ref_no'),
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

    public function edit($id) {
        $gc = Giftcertificate::where('id', $id)->first();
        $service = Services::where('status', 'Active')->pluck('service_name', 'id');
        return view('admin.edit.gc', ['gc' => $gc, 'service' => $service]);        
    }

    public function update(Request $request, $id)
    {
        $data = array(
            'gc_no' => $request->input('gc_no'),
            'ref_no' => $request->input('ref_no'),
            'purchased_by' => $request->input('purchased_by'),
            'service' => $request->input('service'),
            'value' => $request->input('value'),
            'use' => $request->input('use'),
            'date_issued' => $request->input('date_issued'),
            'expiry_date' => $request->input('expiry_date'),
            'status' => 'Active'
        );

        Giftcertificate::where('id', $id)->update($data);
        return redirect('/gift-certificate');

    }

    public function delete($id)
    {
        $gc = Giftcertificate::find($id)->delete();

        return response()->json($gc);

    }
}
