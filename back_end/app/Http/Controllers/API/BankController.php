<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255|unique:banks",
        ]);

        $bank = Bank::create([
            "name" => $request->name,
            "created_by" => Auth::id(),
            "updated_by" => Auth::id(),
        ]);

        return response()->json(
            [
                "message" => "Bank created successfully",
                "bank" => $bank,
            ],
            201
        );
    }

    // Add other CRUD methods as needed
}
