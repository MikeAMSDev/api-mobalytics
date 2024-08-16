<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\CreateUserRequest;

class UserController extends Controller
{
    public function show()
{
    $authenticatedUser = Auth::user();

    $data = [
        'user' => $authenticatedUser,
        'status' => 200
    ];

    return response()->json($data, 200);
}

    public function register(CreateUserRequest $request)
    {
        $validatedData = $request->validated();

        $validatedData['password'] = bcrypt($validatedData['password']);

        unset($validatedData['password_confirmation']);

        $validatedData['roles_id'] = 1;

        $user = User::create($validatedData);

        $data = [
            'message' => 'Usuario creado',
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function update(UpdateUserRequest $request)
    {
        $authenticatedUser = auth()->user();

        $user = User::find($authenticatedUser->id);

        if (!$user) {
            $data = [
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $data = [
            'message' => 'Usuario actualizado',
            'user' => $user,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function destroy()
    {
        $authenticatedUser = Auth::user();

        $user = User::find($authenticatedUser->id);

        if (!$user) {
            $data = [
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        if ($authenticatedUser->tokens) {
            $authenticatedUser->tokens->each(function ($token) {
                $token->delete();
            });
        }

        $user->forceDelete(); 

        $data = [
            'message' => 'Usuario eliminado',
            'status' => 200
        ];

        return response()->json($data, 200);
    }


}