<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LoadType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoadTypeController extends Controller
{
    /**
     * Display a listing of load types.
     */
    public function index()
    {
        $loadTypes = LoadType::all();
        return response()->json(["data" => $loadTypes]);
    }

    /**
     * Store a newly created load type.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string|max:255|unique:load_types",
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

        $loadType = LoadType::create([
            "name" => $request->name,
            "created_by" => Auth::id(),
            "updated_by" => Auth::id(),
        ]);

        return response()->json(
            [
                "message" => "Load type created successfully",
                "data" => $loadType,
            ],
            201
        );
    }

    /**
     * Display the specified load type.
     */
    public function show($id)
    {
        $loadType = LoadType::find($id);

        if (!$loadType) {
            return response()->json(
                [
                    "message" => "Load type not found",
                ],
                404
            );
        }

        return response()->json(["data" => $loadType]);
    }

    /**
     * Update the specified load type.
     */
    public function update(Request $request, $id)
    {
        $loadType = LoadType::find($id);

        if (!$loadType) {
            return response()->json(
                [
                    "message" => "Load type not found",
                ],
                404
            );
        }

        $validator = Validator::make($request->all(), [
            "name" => "required|string|max:255|unique:load_types,name," . $id,
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

        $loadType->update([
            "name" => $request->name,
            "updated_by" => Auth::id(),
        ]);

        return response()->json([
            "message" => "Load type updated successfully",
            "data" => $loadType,
        ]);
    }

    /**
     * Remove the specified load type.
     */
    public function destroy($id)
    {
        $loadType = LoadType::find($id);

        if (!$loadType) {
            return response()->json(
                [
                    "message" => "Load type not found",
                ],
                404
            );
        }

        $loadType->delete();

        return response()->json(
            [
                "message" => "Load type deleted successfully",
            ],
            204
        );
    }
}
