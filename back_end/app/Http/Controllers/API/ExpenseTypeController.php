<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ExpenseType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseTypeController extends Controller
{
    public function index()
    {
        return response()->json(ExpenseType::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "category" => "required|string|max:255",
        ]);

        $expenseType = ExpenseType::create([
            "name" => $request->name,
            "category" => $request->category,
            "created_by" => Auth::id(),
            "updated_by" => Auth::id(),
        ]);

        return response()->json($expenseType, 201);
    }

    // Add show(), update(), destroy() methods similarly
}
