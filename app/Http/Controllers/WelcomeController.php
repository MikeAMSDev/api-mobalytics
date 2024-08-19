<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class WelcomeController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request) {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        if ($user->roles_id !== 2) {
            return response()->json(['message' => 'Unauthorized: User is not an admin'], 401);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return redirect()->intended('/welcome/menu');
    }

    public function showIndex()
    {
        return view('menu');
    }

    public function logout(Request $request) {
        $user = $request->user();
        $user->tokens()->delete();

        Auth::logout();

        return redirect('/');
    }
}