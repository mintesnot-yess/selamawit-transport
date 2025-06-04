<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        $perPage = request()->input('per_page', 15);
        $employees = Employee::paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $employees->items(),
            'meta' => [
                'current_page' => $employees->currentPage(),
                'per_page' => $employees->perPage(),
                'total' => $employees->total(),
                'last_page' => $employees->lastPage(),
                'from' => $employees->firstItem(),
                'to' => $employees->lastItem()
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "first_name" => "required|string|max:255",
            "last_name" => "required|string|max:255",
            "email" => "required|email|unique:employees",
            "phone" => "required|string|max:20",
            "type" => "required|in:STUFF,DRIVER,MECHANIC",
        ]);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }

        $employee = Employee::create([
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "email" => $request->email,
            "phone" => $request->phone,
            "type" => $request->type,
            "hire_date" => $request->hire_date,
            "created_by" => Auth::id(),
            "updated_by" => Auth::id(),
        ]);

        return response()->json($employee, 201);
    }

    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return response()->json($employee);
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $validator = Validator::make($request->all(), [
            "first_name" => "sometimes|string|max:255",
            "last_name" => "sometimes|string|max:255",
            "email" => "sometimes|email|unique:employees,email," . $employee->id,
            "phone" => "sometimes|string|max:20",
            "type" => "sometimes|in:STUFF,DRIVER,MECHANIC",
        ]);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }

        $employee->update($request->all() + ["updated_by" => Auth::id()]);

        return response()->json($employee);
    }

    public function destroy($id)
    {
        Employee::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
