<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Validator as IlluminateValidator;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{


    public function index()
    {
        $users = User::all();
        $perPage = request()->input('per_page', 15);
        $users = User::paginate($perPage);
        $roles = Role::all();


        return response()->json([
            'success' => true,
            'data' => $users->items(),
            'roles' => $roles,
            'meta' => [
                'current_page' => $users->currentPage(),
                'per_page' => $users->perPage(),
                'total' => $users->total(),
                'last_page' => $users->lastPage(),
                'from' => $users->firstItem(),
                'to' => $users->lastItem()
            ]
        ]);


    }
    public function register(Request $request)
    {

        // Validate the request data
        $validator = Validator::make($request->all(), [
            "name" => "required|string|max:255",
            "email" => "required|string|email|max:255|unique:users",
            "password" => "required|string|min:8|confirmed",
            "role" => "exists:roles,id",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "errors" => $validator->errors(),
            ], 422);
        }

        // Create the user
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "created_by" => Auth::id(),
            "updated_by" => Auth::id(),
        ]);

        // Assign role
        $user->roles()->attach($request->role, [
            'user_type' => 'App\Models\User' // Or whatever your user class is
        ]);

        return response()->json([
            "message" => "User registered successfully",
            "user" => $user->load('roles') // Eager load roles if needed
        ], 201);

    }

    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);


        $user = User::where("email", $request->email)->first();

        if (!$user) {
            return response()->json(
                [
                    "message" => "User not found",
                ],
                404
            );
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json(
                [
                    "message" => "Invalid credentials",
                ],
                401
            );
        }

        $token = $user->createToken("auth_token")->plainTextToken;

        return response()->json([
            "access_token" => $token,
            "token_type" => "Bearer",
            "user" => $user,

        ]);
    }
    // update
    public function update(Request $request, $id): JsonResponse
    {
        // Find user by ID
        $user = User::findOrFail($id);

        // Validate request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role' => 'sometimes|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        // Update user fields
        if ($request->has('name')) {
            $user->name = $request->input('name');
        }

        if ($request->has('email')) {
            $user->email = $request->input('email');
        }

        if ($request->has('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        // Optional: Track who updated this user
        $user->updated_by = Auth::id();

        // Save user
        $user->save();
        $roleId = $request->role;

        // Handle role assignment
        if ($request->has('role')) {
            $user->roles()->attach($roleId, [
                'user_type' => get_class($user),
            ]);
        }

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user->load('roles'), // Assuming you have a roles relationship
        ]);
    }
    // destroy
    public function destroy($id): JsonResponse
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            "message" => "User deleted successfully",
        ]);
    }
    public function bulkDelete(Request $request)
    {
        // Validate input
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:users,id'
        ]);

        $ids = $request->input('ids'); // Already decoded by Laravel

        User::whereIn('id', $ids)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Selected users deleted successfully'
        ]);
    }



    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            "message" => "Logged out successfully",
        ]);
    }






}
