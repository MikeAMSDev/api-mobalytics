<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\CompositionDetailedResource;
use Illuminate\Http\Request;
use App\Models\Composition;
use App\Models\User;  
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CommunityCompController extends Controller
{
    public function index(Request $request)
    {
        try {
            $synergyName = $request->query('synergy');
            $sortBy = $request->query('sort_by');
            $includeUserInfo = true;
    
            $synergies = Composition::getCommunityComposition( $synergyName, $sortBy);
    
            if ($synergies->isEmpty()) {
                return response()->json([
                    'message' => 'No compositions found with the provided filters.'
                ], 404);
            }
    
            return CompositionDetailedResource::collection($synergies->map(function ($synergy) use ($includeUserInfo) {
                return new CompositionDetailedResource($synergy, $includeUserInfo);
            }));
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function toggleLike(Request $request, $id)
    {
        try {
            $action = $request->input('action');

            $composition = Composition::findOrFail($id);
            $user = Auth::user();
    
            if (!$user instanceof User) {
                return response()->json([
                    'message' => 'Invalid user instance.'
                ], 400);
            }
    
            $user->toggleAction($composition, $action);
    
            return response()->json([
                'message' => 'Like status updated successfully.',
                'likes' => $composition->likes
            ], 200);
    
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
