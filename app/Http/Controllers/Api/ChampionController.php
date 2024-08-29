<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ShowChampionResource;
use App\Models\Champion;
use App\Http\Resources\SimpleChampionResource;
use Illuminate\Http\JsonResponse;

class ChampionController extends Controller
{
    public function index(Request $request)
    {
        $typeChampion = $request->input('name');
        $cost = $request->input('cost');
        $classSynergy = $request->input('class');
        $originSynergy = $request->input('origin');

        $synergies = Champion::getChampion($typeChampion, $cost, $classSynergy, $originSynergy);

        if ($synergies instanceof JsonResponse) {
            return $synergies;
        }
    
    
        return SimpleChampionResource::collection($synergies);
    }

    public function show($name)
    {
        $synergy = Champion::findOrFailChampions($name);

        if ($synergy instanceof JsonResponse) {
            return $synergy;
        }

        return new ShowChampionResource($synergy);
    }
}