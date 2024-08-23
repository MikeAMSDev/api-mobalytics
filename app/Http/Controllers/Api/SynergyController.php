<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Synergy;
use App\Http\Resources\SynergyResource;

class SynergyController extends Controller
{
    public function index(Request $request)
    {
        $typeSynergy = $request->input('type');
        $synergies = Synergy::getSynergyWithType($typeSynergy);
    
        return SynergyResource::collection($synergies);
    }
}