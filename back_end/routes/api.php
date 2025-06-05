<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BankController;
use App\Http\Controllers\API\BankAccountController;
use App\Http\Controllers\API\ClientsController;
use App\Http\Controllers\API\VehicleController;
use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\ExpenseTypeController;
use App\Http\Controllers\API\ExpenseController;
use App\Http\Controllers\API\LoadTypeController;
use App\Http\Controllers\API\LocationController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\IncomeController;
use App\Http\Controllers\API\LogController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post("/register", [AuthController::class, "register"]);
Route::post("/login", [AuthController::class, "login"]);
Route::post("/forgot-password", [
    ForgotPasswordController::class,
    "sendResetLinkEmail",
]);
Route::post("/reset-password", [ForgotPasswordController::class, "reset"]);

// Authenticated routes
Route::middleware("auth:sanctum")->group(function () {
    // User routes
    Route::get("/user", function (Request $request) {
        return $request->user();
    });
    Route::post("/logout", [AuthController::class, "logout"]);

    // Bank routes
    Route::prefix("banks")->group(function () {
        Route::get("/", [BankController::class, "index"]);
        Route::post("/", [BankController::class, "store"]);
        Route::get("/search", [BankController::class, "search"]);
        Route::delete("/{id}", [BankController::class, "destroy"]);
        Route::put("/{id}", [BankController::class, "update"]);
        // Add other bank routes as needed
    });

    // Bank Accounts routes
    Route::prefix("bank-accounts")->group(function () {
        Route::get("/{bankId}", [BankAccountController::class, "index"]);
        Route::post("/", [BankAccountController::class, "store"]);
        Route::get("/search/{id}", [BankAccountController::class, "search"]);
        Route::delete("/{id}", [BankAccountController::class, "destroy"]);
        Route::put("/{id}", [BankAccountController::class, "update"]);
        // Add other bank account routes as needed
    });

    // Vehicle routes
    Route::prefix("vehicles")->group(function () {
        Route::get("/", [VehicleController::class, "index"]);
        Route::get("/{id}", [VehicleController::class, "show"]);
        Route::post("/", [VehicleController::class, "store"]);
        Route::get("/search", [VehicleController::class, "search"]);
        Route::delete("/{id}", [VehicleController::class, "destroy"]);
        Route::put("/{id}", [VehicleController::class, "update"]);
        // Add other vehicle routes as needed
    });

    // Customer routes
    Route::prefix("clients")->group(function () {
        Route::get("/", [ClientsController::class, "index"]);
        Route::post("/", [ClientsController::class, "store"]);
        Route::get("/search", [ClientsController::class, "search"]);
        Route::delete("/{id}", [ClientsController::class, "destroy"]);
        Route::put("/{id}", [ClientsController::class, "update"]);
        // Add other client routes as needed
    });

    // Employee routes
    Route::prefix("employees")->group(function () {
        Route::get("/", [EmployeeController::class, "index"]);
        Route::post("/", [EmployeeController::class, "store"]);
        Route::delete("/{id}", [EmployeeController::class, "destroy"]);
        Route::put("/{id}", [EmployeeController::class, "update"]);
        // Add other employee routes as needed
    });

    // Expense Type routes
    Route::prefix("expense-types")->group(function () {
        Route::get("/", [ExpenseTypeController::class, "index"]);
        Route::post("/", [ExpenseTypeController::class, "store"]);
        Route::get("/search", [ExpenseTypeController::class, "search"]);
        Route::delete("/{id}", [ExpenseTypeController::class, "destroy"]);
        Route::put("/{id}", [ExpenseTypeController::class, "update"]);
        // Add other expense type routes as needed
    });

    // Expense routes
    Route::prefix("expenses")->group(function () {
        Route::get("/", [ExpenseController::class, "index"]);
        Route::post("/", [ExpenseController::class, "store"]);
        Route::get("/search", [ExpenseController::class, "search"]);
        Route::delete("/{id}", [ExpenseController::class, "destroy"]);
        Route::put("/{id}", [ExpenseController::class, "update"]);
        // Add other expense routes as needed
    });

    // Load Type crud routes
    Route::prefix("load-types")->group(function () {
        Route::get("/", [LoadTypeController::class, "index"]);
        Route::post("/", [LoadTypeController::class, "store"]);
        Route::get("/search", [LoadTypeController::class, "search"]);
        Route::get("/{id}", [LoadTypeController::class, "show"]);
        Route::put("/{id}", [LoadTypeController::class, "update"]);
        Route::delete("/{id}", [LoadTypeController::class, "destroy"]);
    });

    // Location crud routes
    Route::prefix("locations")->group(function () {
        Route::get("/", [LocationController::class, "index"]);
        Route::post("/", [LocationController::class, "store"]);
        Route::get("/search", [LocationController::class, "search"]);
        Route::get("/{id}", [LocationController::class, "show"]);
        Route::put("/{id}", [LocationController::class, "update"]);
        Route::delete("/{id}", [LocationController::class, "destroy"]);
    });

    // Order routes
    Route::prefix('orders')->group(function () {
        Route::apiResource('/', OrderController::class);
    });

    // Income routes
    Route::prefix('incomes')->group(function () {
        Route::apiResource('/', IncomeController::class);
    });

    // Log routes
    Route::prefix('logs')->group(function () {
        Route::get('/', [LogController::class, 'index']);
        Route::get('/{log}', [LogController::class, 'show']);
    });
});
