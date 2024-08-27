<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Http\Requests\BasicItemRequest;


class ItemController extends Controller
{
public function index(Request $request)
{
    $typeObject = $request->input('type_object');
    $items = Item::getItemsWithRequiredItems($typeObject);

    return response()->json($items);
}

public function recipes(BasicItemRequest $request)
{
    $name = $request->input('name');

    $basicItem = Item::where('type_object', 'Basic')
        ->where('name', $name)
        ->first();

    $response = $basicItem->getRecipeDetails();

    return response()->json($response);
}
}