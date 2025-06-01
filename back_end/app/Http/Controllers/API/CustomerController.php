<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string|max:255",
            "contact_person" => "required|string|max:255",
            "phone" => "required|string|max:20",
            "address" => "required|string",
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

        $customer = Customer::create([
            "name" => $request->name,
            "contact_person" => $request->contact_person,
            "phone" => $request->phone,
            "address" => $request->address,
            "created_by" => Auth::id(),
            "updated_by" => Auth::id(),
        ]);

        return response()->json(
            [
                "message" => "Customer created successfully",
                "customer" => $customer,
            ],
            201
        );
    }

    // Add other CRUD methods as needed
    public function index()
    {
        $customers = Customer::all();
        return response()->json($customers);
    }

    public function show($id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return response()->json(["message" => "Customer not found"], 404);
        }
        return response()->json($customer);
    }

    public function update(Request $request, $id)
    {
        // Implement update logic
    }

    public function destroy($id)
    {
        // Implement delete logic
    }
}
