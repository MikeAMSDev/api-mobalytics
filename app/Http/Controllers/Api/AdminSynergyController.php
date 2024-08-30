<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Synergy;
use App\Http\Requests\CreateSynergyRequest;
use App\Http\Requests\UpdateSynergyRequest;
use App\Http\Resources\SynergyResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class AdminSynergyController extends Controller
{

    public function index(Request $request)
    {
        $typeSynergy = $request->input('type');
        $synergies = Synergy::getSynergyWithType($typeSynergy);

        if ($typeSynergy && !in_array($typeSynergy, Synergy::VALID_TYPE_SYNERGY)) {
            return response()->json(['error' => 'Invalid type value.'], 400);
        }
    
        return SynergyResource::collection($synergies);
    }

    public function show($id)
    {
        $synergy = Synergy::findOrFailWithChampions($id);

        if ($synergy instanceof JsonResponse) {
            return $synergy;
        }

        return new SynergyResource($synergy);
    }

    public function create(CreateSynergyRequest $request)
    {
        $synergy = Synergy::createSynergy($request->validated());

        return new SynergyResource($synergy);
    }

    public function update(UpdateSynergyRequest $request, $id)
    {
        $synergy = Synergy::findOrFail($id);

        $synergy->updateSynergy($request->validated());

        return new SynergyResource($synergy);
    }

    public function destroy($id)
    {
        try {
            $synergy = Synergy::findOrFail($id);
            $synergy->deleteSynergy();
    
            return response()->json(['message' => 'Synergy deleted successfully.'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Synergy not found.'], 404);
        } catch (\Exception $e) {

            return response()->json(['error' => 'An error occurred while deleting the synergy.'], 500);
        }
    }

}