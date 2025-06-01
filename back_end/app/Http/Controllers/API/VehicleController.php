<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class VehicleController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "plate_number" => "required|string|max:20|unique:vehicles",
            "owner_name" => "required|string|max:255",
            "owner_phone" => "required|string|max:20",
            "owner_type" => [
                "required",
                Rule::in(["OWNED", "RENTED", "COMPANY"]),
            ],
            "libre" => "nullable|string|max:255",
            "photo" => "nullable|string",
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

        $vehicle = Vehicle::create([
            "plate_number" => $request->plate_number,
            "owner_name" => $request->owner_name,
            "owner_phone" => $request->owner_phone,
            "owner_type" => $request->owner_type,
            "libre" => $request->libre,
            "photo" => $request->photo,
            "created_by" => Auth::id(),
            "updated_by" => Auth::id(),
        ]);

        return response()->json(
            [
                "message" => "Vehicle created successfully",
                "vehicle" => $vehicle,
            ],
            201
        );
    }

    // Add other CRUD methods (index, show, update, destroy) as needed
}
