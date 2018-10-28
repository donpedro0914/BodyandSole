<?php

namespace App\Http\Controllers;

use App\Therapist;
use App\PettyExpense;
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
        $therapist = Therapist::where('status', '!=', 'Terminated')->orderBy('fullname', 'asc')->get();
        return view('admin.therapist', compact('therapist'));
    }

    public function store(Request $request)
    {

        $data = array(
            'fullname' => $request->input('fullname'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'dob' => $request->input('dob'),
            'hired' => $request->input('hired'),
            'resigned' => $request->input('resigned'),
            'basic' => $request->input('basic'),
            'lodging' => $request->input('lodging'),
            'allowance' => $request->input('allowance'),
            'sss' => $request->input('sss'),
            'phealth' => $request->input('phealth'),
            'hdf' => $request->input('hdf'),
            'uniform' => $request->input('uniform'),
            'fare' => $request->input('fare'),
            'others' => $request->input('others'),
            'status' => 'Active'
        );

        $therapist = Therapist::create($data);

        $data2 = array(
            'therapist' => $therapist->id,
            'category' => 'Miscellaneous',
            'value' => 0
        );

        PettyExpense::create($data2);

        return response()->json($therapist);

    }

    public function edit($id, Request $request) {
        $therapist = Therapist::where('id', $id)->first();

        return view('admin.edit.therapist', ['therapist' => $therapist]);
    }

    public function update($id, Request $request) {

        $data = array(
            'fullname' => $request->input('fullname'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'dob' => $request->input('dob'),
            'hired' => $request->input('hired'),
            'resigned' => $request->input('resigned'),
            'lodging' => $request->input('lodging'),
            'basic' => $request->input('basic'),
            'allowance' => $request->input('allowance'),
            'sss' => $request->input('sss'),
            'phealth' => $request->input('phealth'),
            'hdf' => $request->input('hdf'),
            'uniform' => $request->input('uniform'),
            'fare' => $request->input('fare'),
            'others' => $request->input('others'),
            'status' => $request->input('status')
        );

        Therapist::where('id', $id)->update($data);

        $updateTherapist = Therapist::where('id', $id)->first();
        return response()->json($updateTherapist);
    }

    public function delete($id)
    {
        $therapist = Therapist::find($id)->delete();

        return response()->json($therapist);

    }
}
