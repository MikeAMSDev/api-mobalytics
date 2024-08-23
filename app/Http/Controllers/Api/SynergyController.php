<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Synergy;

class SynergyController extends Controller
{
public function index(Request $request)
{
    $typeSynergy = $request->input('type');
    $synergies = Synergy::getSynergyWithType($typeSynergy);

    $synergies = $synergies->map(function ($synergy) {
        $synergy['icon_synergy'] = asset('images/synergies/' . $synergy['icon_synergy']);
        return $synergy;
    });

    return response()->json($synergies);
}
}