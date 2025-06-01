<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index()
    {
        $orders = Order::with([
            "customer",
            "employee",
            "vehicle",
            "loadType",
            "loadingLocation",
            "destinationLocation",
        ])->get();

        return response()->json(["data" => $orders]);
    }

    /**
     * Store a newly created order.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "customer_id" => "required|exists:customers,id",
            "employee_id" => "required|exists:employees,id",
            "vehicle_id" => "required|exists:vehicles,id",
            "loading_place" => "required|exists:locations,id",
            "destination" => "required|exists:locations,id",
            "load_type_id" => "required|exists:load_types,id",
            "quintal" => "required|numeric|min:0",
            "given_tariff" => "required|numeric|min:0",
            "sub_tariff" => "required|numeric|min:0",
            "arrival_at_loading_site" => "required|date",
            "loading_date" =>
                "required|date|after_or_equal:arrival_at_loading_site",
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

        $order = Order::create([
            "customer_id" => $request->customer_id,
            "employee_id" => $request->employee_id,
            "vehicle_id" => $request->vehicle_id,
            "loading_place" => $request->loading_place,
            "destination" => $request->destination,
            "load_type_id" => $request->load_type_id,
            "quintal" => $request->quintal,
            "given_tariff" => $request->given_tariff,
            "sub_tariff" => $request->sub_tariff,
            "order_date" => now(),
            "arrival_at_loading_site" => $request->arrival_at_loading_site,
            "loading_date" => $request->loading_date,
            "current_condition" => "LOADED",
            "payment_collected" => false,
            "status" => "PENDING",
            "created_by" => Auth::id(),
            "updated_by" => Auth::id(),
        ]);

        return response()->json(
            [
                "message" => "Order created successfully",
                "data" => $order,
            ],
            201
        );
    }

    /**
     * Display the specified order.
     */
    public function show($id)
    {
        $order = Order::with([
            "customer",
            "employee",
            "vehicle",
            "loadType",
            "loadingLocation",
            "destinationLocation",
        ])->find($id);

        if (!$order) {
            return response()->json(
                [
                    "message" => "Order not found",
                ],
                404
            );
        }

        return response()->json(["data" => $order]);
    }

    /**
     * Update the specified order.
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(
                [
                    "message" => "Order not found",
                ],
                404
            );
        }

        $validator = Validator::make($request->all(), [
            "customer_id" => "sometimes|exists:customers,id",
            "employee_id" => "sometimes|exists:employees,id",
            "vehicle_id" => "sometimes|exists:vehicles,id",
            "loading_place" => "sometimes|exists:locations,id",
            "destination" => "sometimes|exists:locations,id",
            "load_type_id" => "sometimes|exists:load_types,id",
            "quintal" => "sometimes|numeric|min:0",
            "given_tariff" => "sometimes|numeric|min:0",
            "sub_tariff" => "sometimes|numeric|min:0",
            "arrival_at_loading_site" => "sometimes|date",
            "loading_date" => "sometimes|date",
            "current_condition" => "sometimes|in:LOADED,UNLOADED,IN_TRANSIT",
            "payment_collected" => "sometimes|boolean",
            "status" => "sometimes|in:PENDING,COMPLETED,CANCELLED",
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

        $order->update(
            $request->all() + [
                "updated_by" => Auth::id(),
            ]
        );

        return response()->json([
            "message" => "Order updated successfully",
            "data" => $order,
        ]);
    }

    /**
     * Remove the specified order.
     */
    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(
                [
                    "message" => "Order not found",
                ],
                404
            );
        }

        // Check if order has associated incomes
        if ($order->incomes()->count() > 0) {
            return response()->json(
                [
                    "message" =>
                        "Cannot delete order as it has associated incomes",
                ],
                400
            );
        }

        $order->delete();

        return response()->json(
            [
                "message" => "Order deleted successfully",
            ],
            204
        );
    }
}
