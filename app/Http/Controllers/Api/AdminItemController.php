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
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Exception;


class AdminItemController extends Controller
{

    public function index(Request $request)
    {
        $query = Item::query();
    
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where('name', 'like', "%$searchTerm%");
        }

        $items = $query->get()->map(function ($item) {
            return $item->fresh();
        });
    
        return response()->json($items, 200);
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
    
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to create item or recipe', 'details' => $e->getMessage()], 500);
        }
    }

    public function update(UpdateItemRequest $request, $id): JsonResponse
    {
        $validated = $request->validated();

        $item = Item::findOrFail($id);

        try {
            $item->updateItemWithRecipes($validated);

            $item->fresh('recipes');
    
            return response()->json([
                'message' => 'Item updated correctly.',
                'item' => $item->load('recipes.items')
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }
    public function destroy($id)
    {
        $item = Item::findOrFail($id);

        $item->deleteWithRelations();

        return response()->json(['message' => 'Item and all its relations deleted successfully.']);
    }


}