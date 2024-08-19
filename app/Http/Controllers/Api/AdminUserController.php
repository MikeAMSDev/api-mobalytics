<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateAdminUserRequest;
use App\Http\Requests\CreateAdminUserRequest;

class AdminUserController extends Controller
{

    public function index(Request $request)
    {

        $query = User::query();


        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where('name', 'like', "%$searchTerm%");
        }


        $user = $query->paginate(10);

        return response()->json($user, 200);
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            $data = [
                'message' => 'User not found',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'user' => $user,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function register(CreateAdminUserRequest $request)
    {
        $validatedData = $request->validated();

        $validatedData['password'] = bcrypt($validatedData['password']);

        unset($validatedData['password_confirmation']);
    
        $user = User::create($validatedData);
    
        $data = [
            'message' => 'Usuario creado',
            'status' => 201
        ];
    
        return response()->json($data, 201);
    }

    public function update(UpdateAdminUserRequest $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            $data = [
            'message' => 'User not found',
            'status' => 404
        ];

        return response()->json($data, 404);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'roles_id' => $request->roles_id,
        ]);

        $data = [
            'message' => 'User updated',
            'student' => $user,
            'status' => 200
        ];

        return response()->json($data, 200);
    }


    public function destroy($id)
    {
        $authenticatedUser = Auth::user();

        $user = User::find($id);

        if (!$user) {
            $data = [
                'message' => 'User not found',
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        if ($authenticatedUser->id == $user->id) {
            $authenticatedUser->tokens->each(function ($token) {
                $token->delete();
            });
        }

        $user->forceDelete(); 

        $data = [
            'message' => 'User eliminated',
            'status' => 200
        ];

        return response()->json($data, 200);
    }



}