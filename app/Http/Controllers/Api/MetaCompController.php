<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CompositionDetailedResource;
use App\Models\Composition;
use Exception;
use Illuminate\Support\Facades\Auth;

class MetaCompController extends Controller
{
    public function index(Request $request)
    {
        try {
            $userId = Auth::id();
            $tier = $request->query('tier');
            $synergyName = $request->query('synergy');

            $compositions = Composition::getCompositions($tier, $synergyName, $userId, null, false, true);
    
            if ($compositions->isEmpty()) {
                return response()->json([
                    'message' => 'No compositions found with the provided filters.'
                ], 404);
            }
    
            return CompositionDetailedResource::collection($compositions);
            
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function show($id)
    {
        try {
            $composition = Composition::where('id', $id)
                ->where('type', 'meta')
                ->firstOrFail();

            $formations = $composition->formations()->with('items')->get();

            $formationsData = $formations->map(function ($formation) {
                return [
                    'champion_id' => $formation->champion_id,
                    'item_ids' => $formation->items->pluck('id')->toArray(),
                ];
            })->toArray();

            $synergies = Composition::calculateSynergyActivation($formationsData);

            return (new CompositionDetailedResource($composition))
                ->additional(['synergies_activation' => $synergies]);
    
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

}
