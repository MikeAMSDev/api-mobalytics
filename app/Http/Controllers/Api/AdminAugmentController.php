<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Augment;
use App\Http\Resources\AugmentResource;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CreateAugmentRequest;
use App\Http\Requests\UpdateAugmentRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AdminAugmentController extends Controller
{
    public function index(Request $request)
    {
        $typeAugment = $request->input('tier');

        if ($typeAugment && !in_array($typeAugment, Augment::VALID_TIER)) {
            return response()->json(['error' => 'Invalid tier value.'], 400);
        }
    
        $augments = Augment::getAugmentWithTier($typeAugment);
    
        return AugmentResource::collection($augments);
    }

    public function show($id)
    {
        $augment = Augment::findOrFailAugments($id);

        if ($augment instanceof JsonResponse) {
            return $augment;
        }

        return new AugmentResource($augment);
    }

    public function create(CreateAugmentRequest $request)
    {
        $augment = Augment::createAugment($request->validated());

        return new AugmentResource($augment);
    }

    public function update(UpdateAugmentRequest $request, $id)
    {
        $synergy = Augment::findOrFail($id);

        $synergy->updateAugment($request->validated());

        return new AugmentResource($synergy);
    }

    public function destroy($id)
    {
        try {
            $synergy = Augment::findOrFail($id);
            $synergy->deleteAugment();
    
            return response()->json(['message' => 'Augment deleted successfully.'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Augment not found.'], 404);
        } catch (\Exception $e) {

            return response()->json(['error' => 'An error occurred while deleting the augment.'], 500);
        }
    }

}