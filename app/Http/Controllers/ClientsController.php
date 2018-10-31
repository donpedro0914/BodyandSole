<?php

namespace App\Http\Controllers;

use App\Clients;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class ClientsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $client = Clients::all();
        return view('admin.clients', compact('client'));
    }

    public function store(Request $request)
    {
        $data = array(
            'fullname' => $request->input('fullname'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'dob' => $request->input('dob'),
            'occupation' => $request->input('occupation'),
            'sc_id' => $request->input('sc_id')
        );

        $client = Clients::create($data);

        return response()->json($client);
    }

    public function edit($id, Request $request) {
        $client = Clients::where('id', $id)->first();

        return view('admin.edit.client', ['client' => $client]);
    }

    public function update($id, Request $request) {

        $data = array(
            'fullname' => $request->input('fullname'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'dob' => $request->input('dob'),
            'occupation' => $request->input('occupation'),
            'sc_id' => $request->input('sc_id')
        );

        Clients::where('id', $id)->update($data);

        $updateClient = Clients::where('id', $id)->first();
        return response()->json($updateClient);
    }

    public function delete($id)
    {
        $client = Clients::find($id)->delete();

        return response()->json($client);

    }
}
