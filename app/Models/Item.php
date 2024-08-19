<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class Item extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name','item_bonus', 'tier', 'object_img', 'recipes_id', 'type_object'];

    public const VALID_TYPE_OBJECTS = [
        'Basic', 
        'Combined', 
        'Faerie', 
        'Radiant', 
        'Non-Craftable', 
        'Consumable', 
        'Support', 
        'Artifact'
    ];

    public function champions()
    {
        return $this->belongsToMany(Champion::class);
    }

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

    public function tier()
    {
        return $this->belongsTo(Tier::class);
    }


    public static function getItemsWithRequiredItems($typeObject = null)
    {
        $query = self::query();
    
        if ($typeObject && !in_array($typeObject, self::VALID_TYPE_OBJECTS)) {
            return response()->json(['error' => 'Invalid type_object value.'], 400);
        }
    
        if ($typeObject) {
            $query->where('type_object', $typeObject);
        }
    
        $items = $query->get();
        $itemIds = $items->pluck('id');

        $requiredItems = DB::table('item_recipe')
            ->whereIn('recipe_id', $itemIds)
            ->join('items', 'item_recipe.item_id', '=', 'items.id')
            ->select('item_recipe.recipe_id as parent_item_id', 'items.id as required_item_id', 'items.name', 'items.item_bonus', 'items.tier', 'items.object_img', 'items.type_object')
            ->get()
            ->groupBy('parent_item_id');

        $craftedItems = DB::table('item_recipe')
            ->whereIn('item_id', $itemIds)
            ->join('items as recipes', 'item_recipe.recipe_id', '=', 'recipes.id')
            ->whereIn('recipes.id', function ($query) use ($itemIds) {
                $query->select('items.id')
                      ->from('items')
                      ->join('item_recipe', 'items.id', '=', 'item_recipe.recipe_id')
                      ->whereNotIn('items.type_object', ['Basic'])
                      ->distinct();
            })
            ->select('item_recipe.item_id as ingredient_item_id', 'recipes.id as crafted_item_id', 'recipes.name', 'recipes.item_bonus', 'recipes.tier', 'recipes.object_img', 'recipes.type_object')
            ->get()
            ->groupBy('ingredient_item_id');
            Log::debug('Required Items:', $requiredItems->toArray());
        Log::debug('Crafted Items:', $craftedItems->toArray());
    
        return $items->map(function ($item) use ($requiredItems, $craftedItems) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'item_bonus' => $item->item_bonus,
                'tier' => $item->tier,
                'object_img' => $item->object_img,
                'type_object' => $item->type_object,
                'recipe' => $requiredItems->get($item->id, []),
                'crafted_items' => $craftedItems->get($item->id, []),
            ];
        });
    }

    public static function createWithRecipe(array $data)
    {
        DB::beginTransaction();
    
        try {
            $item = self::create([
                'name' => $data['name'],
                'item_bonus' => $data['item_bonus'],
                'tier' => $data['tier'],
                'object_img' => $data['object_img'],
                'type_object' => $data['type_object'],
            ]);
    
            if (isset($data['has_recipe']) && $data['has_recipe']) {
                $recipe = new Recipe([
                    'name' => $item->name,
                    'description' => $item->item_bonus,
                ]);
    
                $item->recipes()->save($recipe);
    
                if (isset($data['recipe_objects']) && is_array($data['recipe_objects'])) {
                    $recipe->requiredItems()->attach($data['recipe_objects']);
                }
    
                // Verificar que las relaciones se han guardado
                Log::info('Recipe creado con ID: ' . $recipe->id);
                Log::info('Items asociados al recipe: ' . implode(',', $data['recipe_objects']));
            }
    
            DB::commit();
            return $item;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
