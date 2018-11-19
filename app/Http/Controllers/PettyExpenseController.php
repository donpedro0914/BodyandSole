<?php

namespace App\Http\Controllers;

use App\PettyExpense;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PettyExpenseController extends Controller
{

    public function index()
    {

        $now = Carbon::now();
        $start = $now->startOfWeek(Carbon::FRIDAY);
        $end = $now->endOfWeek(Carbon::THURSDAY);
        $day = $start->format('N');
        $startDate = $now->startOfWeek(Carbon::FRIDAY)->format('Y-m-d');
        $endDate = $now->endOfWeek(Carbon::THURSDAY)->format('Y-m-d');

        $expenseCount = PettyExpense::count();
        $expenses = PettyExpense::all();
        return view('admin.expenses', compact('expenses', 'day'),['expenseCount' => $expenseCount, 'startDate' => $startDate, 'endDate' => $endDate]);
    }

    public function edit($id)
    {
        $expense = PettyExpense::where('id', $id)->first();
        return view('admin.edit.petty_expense', ['expense' => $expense]);
    }

    public function update(Request $request, $id)
    {
        $expense = array(
            'ref_no' => $request->input('ref_no'),
            'therapist' => $request->input('therapist'),
            'category' => $request->input('category'),
            'value' => $request->input('value'),
            'particulars' => $request->input('particular'),
        );

        PettyExpense::where('id', $id)->update($expense);
        return redirect('/petty-expense');
    }

    public function delete($id)
    {
        $expense = PettyExpense::find($id)->delete();

        return response()->json($expense);
    }

    public function expenses_filter(Request $request)
    {

        $now = Carbon::now();
        $start = $now->startOfWeek(Carbon::FRIDAY);
        $end = $now->endOfWeek(Carbon::THURSDAY);
        $day = $start->format('N');
        
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $expenseCount = PettyExpense::count();
        
        $expenses = PettyExpense::whereBetween('created_at', [$startDate, $endDate])->get();
        return view('admin.expenses', compact('expenses', 'day'),['expenseCount' => $expenseCount, 'startDate' => $startDate, 'endDate' => $endDate]);
    }

}
