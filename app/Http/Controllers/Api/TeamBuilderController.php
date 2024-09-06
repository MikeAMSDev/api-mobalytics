<?php

namespace App\Http\Controllers\Api;

use App\Models\Champion;
use App\Models\Item;
use App\Models\Composition;
use App\Models\AugmentComp;
use App\Models\Formation;
use App\Models\PrioCarrusel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCompositionRequest;
use App\Http\Resources\SimpleChampionResource;
use App\Http\Resources\SimpleItemResource;
use App\Http\Requests\FilterChampionRequest;
use App\Http\Requests\FilterItemRequest;
use App\Http\Requests\UpdateCompositionRequest;
use App\Http\Resources\CompositionResource;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;



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

    public function create(CreateCompositionRequest $request)
    {
        try {
            $composition = Composition::createWithFormations(
                $request->validated(),
                $request->input('formations', []),
                $request->input('prio_carrusel', []),
                $request->input('augments', []),
                auth()->id()
            );

            return new CompositionResource($composition);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
    
            return response()->json([
                'error' => 'An error occurred while saving the composition.',
                'message' => $e->getMessage()
            ], 500);
        } catch (\Exception $e) {

            return response()->json([
                'error' => 'An unexpected error occurred.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
