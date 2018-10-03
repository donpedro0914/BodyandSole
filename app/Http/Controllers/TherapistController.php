<?php

namespace App\Http\Controllers;

use App\Therapist;
use Illuminate\Http\Request;
use File;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class TherapistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $therapist = Therapist::where('status', '!=', 'Terminated')->get();
        return view('admin.therapist', compact('therapist'));
    }

    public function store(Request $request)
    {
        if($request->hasFile('avatar')) {

            $path = public_path().'/avatar/';

            if(!File::exists($path)) {
                File::makeDirectory($path, $mode = 0777, true, true);
            }

            $filename = $request->file('avatar')->getClientOriginalName();
            $filename = 'avatar-'.time().'-'.$filename;
            $request->file('avatar')->move($path, $filename);
            $avatar = $filename;

        } else {

            $avatar = "";

        }

        $data = array(
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'dob' => $request->input('dob'),
            'hired' => $request->input('hired'),
            'resigned' => $request->input('resigned'),
            'lodging' => $request->input('lodging'),
            'allowance' => $request->input('allowance'),
            'sss' => $request->input('sss'),
            'phealth' => $request->input('phealth'),
            'hdf' => $request->input('hdf'),
            'uniform' => $request->input('uniform'),
            'fare' => $request->input('fare'),
            'others' => $request->input('others'),
            'avatar' => $avatar,
            'status' => 'Active'
        );

        $therapist = Therapist::create($data);

        return response()->json($therapist);

    }
}
