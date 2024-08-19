<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateItemRequest;
use App\Http\Requests\CreateItemRequest;
use App\Models\Item;
use App\Models\Recipe;
use App\Models\ItemRecipe;
use Illuminate\Support\Facades\DB;


class AdminItemController extends Controller
{

    public function index(Request $request)
    {

        $query = Item::query();


        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where('name', 'like', "%$searchTerm%");
        }


        $item = $query->paginate(10);

        return response()->json($item, 200);
    }

    public function show($id)
    {
        $item = Item::find($id);

        if (!$item) {
            $data = [
                'message' => 'Item not found',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'item' => $item,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function create(CreateItemRequest $request)
    {
        try {
            $item = Item::createWithRecipe($request->validated());
    
            return response()->json([
                'item' => $item,
                'message' => 'Item created successfully',
                'status' => 201,
            ], 201);
    
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create item or recipe', 'details' => $e->getMessage()], 500);
        }
    }
    public function update(UpdateItemRequest $request, $id)
    {
        $user = Item::find($id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'roles_id' => $request->roles_id,
        ]);

        $data = [
            'message' => 'Usuario actualizado',
            'student' => $user,
            'status' => 200
        ];

        return response()->json($data, 200);
    }


    public function destroy($id)
    {
        $authenticatedUser = Auth::user();

        $user = Item::find($id);

        if (!$user) {
            $data = [
                'message' => 'Usuario no encontrado',
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
            'message' => 'Usuario eliminado',
            'status' => 200
        ];

        return response()->json($data, 200);
    }



}