<?php

namespace App\Http\Controllers;

use App\Clients;
use Illuminate\Http\Request;
use DataTables;

class ClientsController extends Controller
{
    
    public function index()
    {
        return view('admin.clients');
    }

    public function store(Request $request)
    {
        $data = array(
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'dob' => $request->input('dob'),
            'occupation' => $request->input('occupation'),
            'sc_id' => $request->input('sc_id')
        );

        $client = Clients::create($data);

        return response()->json($client);
    }

    public function client_list() {
        $client = Clients::all();
        return DataTables::of($client)->make(true);
    }
}
