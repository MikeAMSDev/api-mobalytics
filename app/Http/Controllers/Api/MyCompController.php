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
use App\Http\Resources\SimpleCompositionResource;
use Illuminate\Support\Facades\Auth; 
use Exception;
use Barryvdh\DomPDF\Facade\Pdf;

class MyCompController extends Controller
{

    public function index(Request $request)
    {
        try {
            $userId = Auth::id();
            $tier = $request->query('tier');
            $synergyName = $request->query('synergy');

            $compositions = Composition::getCompositions($tier, $synergyName, $userId, null, false);
    
            if ($compositions->isEmpty()) {
                return response()->json([
                    'message' => 'No compositions found with the provided filters.'
                ], 404);
            }
    
            return CompositionDetailedResource::collection($compositions);
            
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function show(Request $request, $id)
    {
        try {

            $composition = Composition::whereHas('userCompo', function ($query) {
                $query->where('user_id', Auth::id());
            })->find($id);

            if (!$composition) {
                return response()->json([
                    'error' => 'Unauthorized or composition not found.'
                ], 403);
            }

            return new CompositionDetailedResource($composition);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
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

    public function generateMyCompPDF(Request $request, $id)
    {
        try {
            $userId = auth()->id();

            $comp = Composition::getUserCompositionById($id, $userId);
        
            if (!$comp) {
                return response()->json([
                    'error' => 'Composición no encontrada o no pertenece al usuario'
                ], 404);
            }

            $compResource = new CompositionDetailedResource($comp, true);
    
            $data = [
                'title' => $compResource->toArray($request),
                'date' => date('m/d/Y'),
            ];

            $pdf = Pdf::loadView('pdf.myCompPDF', $data);
    
            return $pdf->download('mi-archivo.pdf');
            
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }


    public function changeCompositionType(Request $request, $id)
    {
        try {
            $composition = Composition::findOrFail($id);

            $type = $request->input('type');

            $result = $composition->changeType($type);

            if ($result === true) {
                return new SimpleCompositionResource($composition);
            }

            return response()->json(['error' => $result], 403);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
