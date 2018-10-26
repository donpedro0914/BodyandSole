<?php

namespace App\Http\Controllers;

use App\PettyExpense;
use App\Therapist;
use Illuminate\Http\Request;

class PettyExpenseController extends Controller
{

    public function index()
    {
        $therapist = Therapist::where('status', 'Active')->get();
        return view('expenses', compact('therapist'));
    }

}
