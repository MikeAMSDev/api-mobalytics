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

    public function recipe()
    {
        return $this->belongsToMany(Recipe::class,'item_recipe');
    }

    public function recipes()
    {
        return $this->hasMany(Recipe::class, 'item_id');
    }

    public function craftedItems()
    {
        return $this->belongsToMany(Recipe::class, 'item_recipe', 'item_id', 'recipe_id')
        ->withPivot('item_id');
    }
    public function requiredItems()
    {
        return $this->belongsToMany(Item::class, 'item_recipe', 'recipe_id', 'item_id');
    }

    public function tier()
    {
        return $this->belongsTo(Tier::class);
    }

    public static function getItemsWithFilters($filters = [])
    {
        $query = self::query();

        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        if (!empty($filters['recipe_object'])) {
            $query->whereHas('recipes.items', function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['recipe_object'] . '%');
            })->with(['recipes.items']);
        }

        return $query->get();
    }

    public static function getItemsWithRequiredItems($typeObject = null)
    {
        $query = self::with([
            'recipes.items',
            'craftedItems',
        ]);
    
        if ($typeObject && !in_array($typeObject, self::VALID_TYPE_OBJECTS)) {
            return response()->json(['error' => 'Invalid type_object value.'], 400);
        }
    
        if ($typeObject) {
            $query->where('type_object', $typeObject);
        }
    
        $items = $query->get();
    
        return $items->map(function ($item) {

            $recipes = $item->recipes->map(function ($recipe) {
                return $recipe->items->map(function ($requiredItem) {
                    return [
                        'id' => $requiredItem->id,
                        'name' => $requiredItem->name,
                        'item_bonus' => $requiredItem->item_bonus,
                        'tier' => $requiredItem->tier,
                        'object_img' => url('images/items/' . $requiredItem->object_img),
                        'type_object' => $requiredItem->type_object,
                    ];
                });
            })->flatten(1);

            $craftedItems = $item->craftedItems
                ->filter(function ($recipe) {
                    return $recipe->type_object !== 'Basic';
                })
                ->map(function ($recipe) use ($item) {
                    $relatedItem = Item::find($recipe->item_id);
    
                    $itemBonus = $relatedItem ? $relatedItem->item_bonus : null;
                    $objectImg = $relatedItem ? $relatedItem->object_img : null;
                    $typeObject = $relatedItem ? $relatedItem->type_object : null; 
                    $tier = $relatedItem ? $relatedItem->tier : null;
    
                    return [
                        'parent_item_id' => $recipe->item_id,
                        'required_item_id' => $recipe->id,
                        'name' => $recipe->name,
                        'tier' => $tier,
                        'item_bonus' => $itemBonus,
                        'object_img' => url('images/items/' . $objectImg),
                        'type_object' => $typeObject,
                        'recipe' => $recipe->items->map(function ($requiredItem) {
                            return [
                                'id' => $requiredItem->id,
                                'name' => $requiredItem->name,
                                'item_bonus' => $requiredItem->item_bonus,
                                'tier' => $requiredItem->tier,
                                'object_img' => url('images/items/' . $requiredItem->object_img),
                                'type_object' => $requiredItem->type_object,
                            ];
                        }),
                    ];
                })->unique(function ($item) {
                    return $item['parent_item_id'] . '-' . $item['required_item_id'];
                });
    
            return [
                'id' => $item->id,
                'name' => $item->name,
                'item_bonus' => $item->item_bonus,
                'tier' => $item->tier,
                'object_img' => url('images/items/' . $item->object_img),
                'type_object' => $item->type_object,
                'recipe' => $recipes,
                'crafted_items' => $craftedItems,
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
    
            Log::debug('Item creado', ['item' => $item]);
    
            if (isset($data['has_recipe']) && $data['has_recipe']) {
                $recipe = new Recipe([
                    'name' => $item->name,
                    'description' => $item->item_bonus,
                    'item_id' => $item->id,
                ]);
                $recipe->save();
    
                $recipe->items()->attach($data['recipe_objects']);
            }
    
            DB::commit();
            return $item;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateItemWithRecipes(array $validatedData)
    {
        $this->update([
            'name' => $validatedData['name'],
            'item_bonus' => $validatedData['item_bonus'],
            'tier' => $validatedData['tier'],
            'object_img' => $validatedData['object_img'],
            'type_object' => $validatedData['type_object'],
        ]);
    
        if (isset($validatedData['recipes'])) {
            $recipeData = $validatedData['recipes'][0];

            $recipe = Recipe::firstOrNew([
                'id' => $recipeData['id'] ?? null,
                'item_id' => $this->id,
            ]);
    
            $recipe->fill([
                'name' => $recipeData['name'],
                'description' => $recipeData['description'],
            ])->save();

            DB::table('item_recipe')->where('recipe_id', $recipe->id)->delete();
    
            foreach ($recipeData['item_ids'] as $itemId) {
                DB::table('item_recipe')->insert([
                    'recipe_id' => $recipe->id,
                    'item_id' => $itemId
                ]);
            }
        } else {
            Recipe::where('item_id', $this->id)->delete();
        }
    }
    public function deleteWithRelations()
    {
        $recipes = Recipe::where('item_id', $this->id)->get();

        foreach ($recipes as $recipe) {
            $recipe->itemRecipes()->delete();

            $recipe->delete();
        }

        $this->delete();
    }

    public function getFinalItemsFromRecipes()
    {
        $recipes = $this->recipe()->get();
        $finalItemIds = $recipes->pluck('item_id')->unique();

        return Item::whereIn('id', $finalItemIds)->get()->keyBy('id');
    }

    public function getRecipeDetails()
    {
        $recipes = $this->recipe()->get();
        $finalItems = $this->getFinalItemsFromRecipes();

        $response = $recipes->map(function ($recipe) use ($finalItems) {
            $finalItem = $finalItems->get($recipe->item_id);
    
            $itemsInRecipe = $recipe->items()->get()->map(function ($item) {
                return [
                    'name' => $item->name,
                    'object_img' => url('/images/items/' . $item->object_img),
                ];
            });
    
            return $finalItem ? [
                'name' => $finalItem->name,
                'item_bonus' => $finalItem->item_bonus,
                'tier' => $finalItem->tier,
                'object_img' => url('/images/items/' . $finalItem->object_img),
                'recipe' => $itemsInRecipe,
            ] : null;
        });

        return $response->filter()->unique('name')->values();
    }
}
