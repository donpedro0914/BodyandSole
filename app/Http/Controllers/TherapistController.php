<?php

namespace App\Http\Controllers;

use App\Therapist;
use Illuminate\Http\Request;

class TherapistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.therapist');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Therapist  $therapist
     * @return \Illuminate\Http\Response
     */
    public function show(Therapist $therapist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Therapist  $therapist
     * @return \Illuminate\Http\Response
     */
    public function edit(Therapist $therapist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Therapist  $therapist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Therapist $therapist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Therapist  $therapist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Therapist $therapist)
    {
        //
    }
}
