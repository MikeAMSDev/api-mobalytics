<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Augment;
use App\Http\Resources\AugmentResource;

class AugmentController extends Controller
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
}