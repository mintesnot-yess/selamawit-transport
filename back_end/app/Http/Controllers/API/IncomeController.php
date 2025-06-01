<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class IncomeController extends Controller
{
    /**
     * Display a listing of incomes.
     */
    public function index()
    {
        $incomes = Income::with(["order", "creator", "updater"])->get();
        return response()->json(["data" => $incomes]);
    }

    /**
     * Store a newly created income.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "order_id" => "required|exists:orders,id",
            "amount" => "required|numeric|min:0",
            "received_date" => "required|date",
            "description" => "nullable|string",
            "attachment" => "nullable|string",
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    "message" => "Validation error",
                    "errors" => $validator->errors(),
                ],
                422
            );
        }

        $income = Income::create([
            "order_id" => $request->order_id,
            "amount" => $request->amount,
            "received_date" => $request->received_date,
            "description" => $request->description ?? "no desc",
            "attachment" => $request->attachment ?? "no atach",
            "created_by" => Auth::id(),
            "updated_by" => Auth::id(),
        ]);

        return response()->json(
            [
                "message" => "Income created successfully",
                "data" => $income,
            ],
            201
        );
    }

    /**
     * Display the specified income.
     */
    public function show($id)
    {
        $income = Income::with(["order", "creator", "updater"])->find($id);

        if (!$income) {
            return response()->json(
                [
                    "message" => "Income not found",
                ],
                404
            );
        }

        return response()->json(["data" => $income]);
    }

    /**
     * Update the specified income.
     */
    public function update(Request $request, $id)
    {
        $income = Income::find($id);

        if (!$income) {
            return response()->json(
                [
                    "message" => "Income not found",
                ],
                404
            );
        }

        $validator = Validator::make($request->all(), [
            "order_id" => "sometimes|exists:orders,id",
            "amount" => "sometimes|numeric|min:0",
            "received_date" => "sometimes|date",
            "description" => "nullable|string",
            "attachment" => "nullable|string",
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    "message" => "Validation error",
                    "errors" => $validator->errors(),
                ],
                422
            );
        }

        $income->update(
            $request->all() + [
                "updated_by" => Auth::id(),
            ]
        );

        return response()->json([
            "message" => "Income updated successfully",
            "data" => $income,
        ]);
    }

    /**
     * Remove the specified income.
     */
    public function destroy($id)
    {
        $income = Income::find($id);

        if (!$income) {
            return response()->json(
                [
                    "message" => "Income not found",
                ],
                404
            );
        }

        $income->delete();

        return response()->json(
            [
                "message" => "Income deleted successfully",
            ],
            204
        );
    }
}
