<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function showLoginForm() {
        return view('auth.signin');
    }
    
    public function login(LoginRequest $request) {
        $validated = $request->validated();

        $user = User::where("email", $validated["email"])->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false, 
                'message' => 'Invalid credentials'
                ],401);
        }
        
        $token = $user->createToken($request->email);

        return response()->json([
            'success' => true,
            'user' => $user,
            'token' => $token->plainTextToken,
        ], 201);
    }

    public function logout(Request $request) {
        return 'logout';
    }
}
