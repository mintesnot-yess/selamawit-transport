<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            "expense_type_id" => "required|exists:expense_types,id",
            "vehicle_id" => "required|exists:vehicles,id",
            "employee_id" => "required|exists:employees,id",
            "amount" => "required|numeric",
            "paid_date" => "required|date",
        ]);

        $expense = Expense::create([
            "expense_type_id" => $request->expense_type_id,
            "vehicle_id" => $request->vehicle_id,
            "employee_id" => $request->employee_id,
            "amount" => $request->amount,
            "paid_date" => $request->paid_date,
            "created_by" => Auth::id(),
            "updated_by" => Auth::id(),
        ]);

        return response()->json($expense, 201);
    }

    // Add other CRUD methods
}
