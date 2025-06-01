<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BankController;
use App\Http\Controllers\API\BankAccountController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\VehicleController;
use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\ExpenseTypeController;
use App\Http\Controllers\API\ExpenseController;
use App\Http\Controllers\API\LoadTypeController;
use App\Http\Controllers\API\LocationController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\IncomeController;

use App\Http\Controllers\ForgotPasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get("/user", function (Request $request) {
    return $request->user();
})->middleware("auth:sanctum");
Route::post("/register", action: [AuthController::class, "register"]);
Route::post("/login", [AuthController::class, "login"]);
Route::middleware("auth:sanctum")->post("/logout", [AuthController::class, "logout"]);
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('/reset-password', [ForgotPasswordController::class, 'reset']);

Route::middleware("auth:sanctum")->group(function () {
    Route::post("/banks", [BankController::class, "store"]);
    // Add other bank routes as needed
});
Route::middleware("auth:sanctum")->group(function () {
    Route::post("/bank-accounts", [BankAccountController::class, "store"]);
    // Add other bank account routes as needed
});

Route::middleware("auth:sanctum")->group(function () {
    Route::post("/vehicles", [VehicleController::class, "store"]);
    // Add other vehicle routes as needed
    // Route::get('/vehicles', [VehicleController::class, 'index']);
    // Route::get('/vehicles/{id}', [VehicleController::class, 'show']);
    // Route::put('/vehicles/{id}', [VehicleController::class, 'update']);
    // Route::delete('/vehicles/{id}', [VehicleController::class, 'destroy']);
});

Route::middleware("auth:sanctum")->group(function () {
    Route::post("/customers", [CustomerController::class, "store"]);
    // Route::get('/customers', [CustomerController::class, 'index']);
    // Route::get('/customers/{id}', [CustomerController::class, 'show']);
    // Route::put('/customers/{id}', [CustomerController::class, 'update']);
    // Route::delete('/customers/{id}', [CustomerController::class, 'destroy']);
});

Route::middleware("auth:sanctum")->group(function () {
    Route::apiResource("employees", EmployeeController::class);
    Route::apiResource("expense-types", ExpenseTypeController::class);
    Route::apiResource("expense", ExpenseController::class);
});

Route::middleware("auth:sanctum")->group(function () {
    // Load Types API Routes
    Route::get("/load-types", [LoadTypeController::class, "index"]);
    Route::post("/load-types", [LoadTypeController::class, "store"]);
    Route::get("/load-types/{id}", [LoadTypeController::class, "show"]);
    Route::put("/load-types/{id}", [LoadTypeController::class, "update"]);
    Route::delete("/load-types/{id}", [LoadTypeController::class, "destroy"]);
});

Route::middleware("auth:sanctum")->group(function () {
    // Locations API Routes
    Route::get("/locations", [LocationController::class, "index"]);
    Route::post("/locations", [LocationController::class, "store"]);
    Route::get("/locations/{id}", [LocationController::class, "show"]);
    Route::put("/locations/{id}", [LocationController::class, "update"]);
    Route::delete("/locations/{id}", [LocationController::class, "destroy"]);
});

Route::middleware("auth:sanctum")->group(function () {
    // Orders API Routes
    Route::get("/orders", [OrderController::class, "index"]);
    Route::post("/orders", [OrderController::class, "store"]);
    Route::get("/orders/{id}", [OrderController::class, "show"]);
    Route::put("/orders/{id}", [OrderController::class, "update"]);
    Route::delete("/orders/{id}", [OrderController::class, "destroy"]);
});

Route::middleware("auth:sanctum")->group(function () {
    // Incomes API Routes
    Route::get("/incomes", [IncomeController::class, "index"]);
    Route::post("/incomes", [IncomeController::class, "store"]);
    Route::get("/incomes/{id}", [IncomeController::class, "show"]);
    Route::put("/incomes/{id}", [IncomeController::class, "update"]);
    Route::delete("/incomes/{id}", [IncomeController::class, "destroy"]);
});

Route::middleware("auth:sanctum")->group(function () {
    // Logs routes
    Route::get("/logs", [
        \App\Http\Controllers\API\LogController::class,
        "index",
    ]);
    Route::get("/logs/{log}", [
        \App\Http\Controllers\API\LogController::class,
        "show",
    ]);

    // Your other API routes...
});
