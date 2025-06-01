<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Dotenv\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator as IlluminateValidator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validate the request data
        $validator = IlluminateValidator::make($request->all(), [
            "name" => "required|string|max:255",
            "email" => "required|string|email|max:255|unique:users",
            "password" => "required|string|min:8|confirmed",
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    "errors" => $validator->errors(),
                ],
                422
            );
        }

        // Determine the creating user (1 for system/admin if no authenticated user)
        $creatingUserId = Auth::check() ? Auth::id() : 1;

        // Create the user
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "created_by" => $creatingUserId,
            "updated_by" => $creatingUserId,
        ]);

        // Optionally create and return an access token
        $token = $user->createToken("auth_token")->plainTextToken;

        return response()->json(
            [
                "message" => "User registered successfully",
                "access_token" => $token,
                "token_type" => "Bearer",
                "user" => $user,
            ],
            201
        );
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




    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            "message" => "Logged out successfully",
        ]);
    }






}
