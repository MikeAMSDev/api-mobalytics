<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthAdminController extends Controller{

    public function index(){
       return User::all();
    }
    public function login(Request $request) {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Unauthorized, One of the fields is not correct'], 401);
        }
    
        $user = User::where('email', $request['email'])->firstOrFail();
    
        if ($user->roles_id !== 2) {
            return response()->json(['message' => 'Unauthorized: User is not an admin'], 401);
        }
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Hi ' . $user->name ,
            'accessToken' => $token,
            'user' => $user,
        ]);
    }

    public function logout(Request $request) {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }
}