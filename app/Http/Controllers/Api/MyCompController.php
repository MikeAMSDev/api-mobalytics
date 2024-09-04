<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CompositionDetailedResource;
use App\Models\Composition;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\UpdateCompositionRequest;
use App\Http\Resources\CompositionResource;
use Exception;

class MyCompController extends Controller
{
    public function index(Request $request)
    {
        $typeSynergy = $request->input('type');
        $synergies = Composition::getComposition($typeSynergy);
    
        return CompositionDetailedResource::collection($synergies);
    }

    public function update(UpdateCompositionRequest $request, $id)
    {
        try {
            $composition = Composition::updateComposition(
                $id,
                $request->validated(),
                $request->input('formations', []),
                $request->input('prio_carrusel', []),
                $request->input('augments', [])
            );
    
            return new CompositionResource($composition);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            return response()->json([
                'error' => 'An error occurred while updating the composition.',
                'message' => 'There was a problem processing your request. Please try again later.'
            ], 500);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred.',
                'message' => 'There was a problem processing your request. Please try again later.'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            // Buscar la composición por ID y eliminarla
            $composition = Composition::findOrFail($id);
            $composition->deleteComposition();

            return response()->json([
                'status' => 'success',
                'message' => 'Composition deleted successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
