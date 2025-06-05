<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\ExpenseType;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{


    public function index()
    {
        $perPage = request()->input('per_page', 15);

        // Eager load related models
        $query = Expense::with(relations: ['expenseType', 'vehicle', 'employee', 'fromBank', 'toBank', 'fromAccount']);

        $CategoryEmployee = ExpenseType::where('category', 'Employee')->get();
        $CategoryVehicle = ExpenseType::where('category', 'Vehicle')->get();
        $CategoryGeneral = ExpenseType::where('category', 'General')->get();

        $employees = Employee::all();
        $Vehicles = Vehicle::all();
        $Banks = Bank::all();
        $BanksAccount = BankAccount::all();
        $expenses = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $expenses->items(),
            'CategoryEmployee' => $CategoryEmployee,
            'CategoryVehicle' => $CategoryVehicle,
            'CategoryGeneral' => $CategoryGeneral,
            'AllEmployees' => $employees,
            'AllVehicles' => $Vehicles,
            'AllBanks' => $Banks,
            'AllBanksAccount' => $BanksAccount,
            'meta' => [
                'current_page' => $expenses->currentPage(),
                'per_page' => $expenses->perPage(),
                'total' => $expenses->total(),
                'last_page' => $expenses->lastPage(),
                'from' => $expenses->firstItem(),
                'to' => $expenses->lastItem()
            ]
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            "General_category" => "nullable:expense_types,id",
            "employees_category" => "nullable:expense_types,id",
            "vehicle_category" => "nullable:expense_types,id",
            "vehicle_id" => "nullable|exists:vehicles,id",
            "employee_id" => "nullable|exists:employees,id",
            "selectedBank" => "nullable|exists:banks,id",
            "selectedAccount" => "nullable|exists:bank_accounts,id",
            "toBank" => "nullable|exists:banks,id",
            "toAccount" => "string|nullable",
            "amount" => "required|numeric",
            "paid_date" => "required|date",
            "remark" => "nullable|string",
            "file" => "nullable|max:2048",
        ]);

        $expense = Expense::create([
            "expense_type_id" => $request->General_category ?? $request->employees_category ?? $request->vehicle_category,
            "vehicle_id" => $request->vehicle_id,
            "employee_id" => $request->employee_id,
            "from_account" => $request->selectedAccount,
            "to_account" => $request->toAccount,
            "to_bank" => $request->toBank,
            "from_bank" => $request->selectedBank,
            "amount" => $request->amount,
            "paid_date" => $request->paid_date,
            "remark" => $request->remark,
            "file" => $request->file('file') ? $request->file('file')->store('expenses', 'public') : null,
            "created_by" => Auth::id(),
            "updated_by" => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'data' => $expense,
            'message' => 'Expense  created successfully.'
        ], 201);

    }


    public function update(Request $request, $id)
    {
        $expense = Expense::find($id);

        if (!$expense) {
            return response()->json(['success' => false, 'message' => 'Expense not found.'], 404);
        }

        $validated = $request->validate([
            "General_category" => "nullable|exists:expense_types,id",
            "employees_category" => "nullable|exists:expense_types,id",
            "vehicle_category" => "nullable|exists:expense_types,id",
            "vehicle_id" => "nullable|exists:vehicles,id",
            "employee_id" => "nullable|exists:employees,id",
            "selectedBank" => "nullable|exists:banks,id",
            "selectedAccount" => "nullable|exists:bank_accounts,id",
            "toBank" => "nullable|exists:banks,id",
            "toAccount" => "string|nullable",
            "amount" => "required|numeric",
            "paid_date" => "required|date",
            "remark" => "nullable|string",
            "file" => "nullable|max:2048",
        ]);

        // Set expense_type_id based on which category is provided
        $validated['expense_type_id'] = $request->General_category ?? $request->employees_category ?? $request->vehicle_category;

        // Set from_bank and to_bank fields, retain existing if not provided
        $validated['from_bank'] = $request->has('selectedBank') && $request->selectedBank !== null ? $request->selectedBank : $expense->from_bank;
        $validated['from_account'] = $request->has('selectedAccount') && $request->selectedAccount !== null ? $request->selectedAccount : $expense->from_account;
        $validated['to_bank'] = $request->has('toBank') && $request->toBank !== null ? $request->toBank : $expense->to_bank;

        // Handle file upload if present
        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('expenses', 'public');
        }

        $validated['updated_by'] = Auth::id();

        $expense->update($validated);

        return response()->json(['success' => true, 'data' => $expense]);
    }

    public function destroy($id)
    {
        $expense = Expense::find($id);

        if (!$expense) {
            return response()->json(['success' => false, 'message' => 'Expense not found.'], 404);
        }

        $expense->delete();

        return response()->json(['success' => true, 'message' => 'Expense deleted successfully.']);
    }

    public function search(Request $request)
    {
        try {
            $query = Expense::query();

            // Basic search
            if ($request->has('q')) {
                $searchTerm = $request->input('q');
                $query->where('amount', 'like', '%' . $searchTerm . '%')
                    ->orWhere('paid_date', 'like', '%' . $searchTerm . '%');
            }

            // Filter by expense_type_id, vehicle_id, employee_id if provided
            if ($request->has('expense_type_id')) {
                $query->where('expense_type_id', $request->input('expense_type_id'));
            }
            if ($request->has('vehicle_id')) {
                $query->where('vehicle_id', $request->input('vehicle_id'));
            }
            if ($request->has('employee_id')) {
                $query->where('employee_id', $request->input('employee_id'));
            }

            // Pagination
            $perPage = $request->input('per_page', 15);
            $expenses = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $expenses->items(),
                'meta' => [
                    'current_page' => $expenses->currentPage(),
                    'per_page' => $expenses->perPage(),
                    'total' => $expenses->total(),
                    'last_page' => $expenses->lastPage(),
                    'from' => $expenses->firstItem(),
                    'to' => $expenses->lastItem()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Search failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Add other CRUD methods
}
