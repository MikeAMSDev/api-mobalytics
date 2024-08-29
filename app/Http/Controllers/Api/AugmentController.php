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
        $augments = Augment::getAugmentWithTier($typeAugment);
    
        return AugmentResource::collection($augments);
    }
}