<?php

namespace App\Http\Controllers\Api;

use App\Models\Champion;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SimpleChampionResource;
use App\Http\Resources\SimpleItemResource;
use App\Http\Requests\FilterChampionRequest;
use App\Http\Requests\FilterItemRequest;


class TeamBuilderController extends Controller
{
    public function index(FilterChampionRequest $championRequest, FilterItemRequest $itemRequest)
    {
        $viewType = $championRequest->input('view_type', 'champions');

        if ($viewType === 'items') {
            $filters = $itemRequest->only(['name', 'recipe_object']);
            $items = Item::getItemsWithFilters($filters);

            if ($items->isEmpty()) {
                return response()->json(['error' => 'No items found matching the given criteria.'], 404);
            }

            return response()->json(SimpleItemResource::collection($items));
        } else {
            $filters = $championRequest->only(['name', 'synergy', 'cost', 'alphabetical_order']);
            $champions = Champion::getChampionsWithFilters($filters);

            if ($champions->isEmpty()) {
                return response()->json(['error' => 'No champions found matching the given criteria.'], 404);
            }

            return response()->json(SimpleChampionResource::collection($champions));
        }
    }
}
