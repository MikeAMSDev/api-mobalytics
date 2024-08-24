<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Synergy;
use App\Http\Requests\CreateSynergyRequest;
use App\Http\Resources\SynergyResource;


class AdminSynergyController extends Controller
{

    public function index(Request $request)
    {
        $typeSynergy = $request->input('type');
        $synergies = Synergy::getSynergyWithType($typeSynergy);
    
        return SynergyResource::collection($synergies);
    }

    public function show($id)
    {
        $synergy = Synergy::findOrFailWithChampions($id);

        return new SynergyResource($synergy);
    }

    public function create(CreateSynergyRequest $request)
    {
        $synergy = Synergy::createSynergy($request->validated());

        return new SynergyResource($synergy);
    }

}