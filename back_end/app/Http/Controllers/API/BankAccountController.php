<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BankAccountController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "account_number" => "required|string|max:255|unique:bank_accounts",
            "bank_id" => "required|exists:banks,id",
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    "errors" => $validator->errors(),
                ],
                422
            );
        }

        $bankAccount = BankAccount::create([
            "account_number" => $request->account_number,
            "bank_id" => $request->bank_id,
            "created_by" => Auth::id(),
            "updated_by" => Auth::id(),
        ]);

        return response()->json(
            [
                "message" => "Bank account created successfully",
                "bank_account" => $bankAccount,
            ],
            201
        );
        log_action(
            "Created " . class_basename($bankAccount) . " #" . $bankAccount->id
        );
    }

    // Add other CRUD methods as needed
}
