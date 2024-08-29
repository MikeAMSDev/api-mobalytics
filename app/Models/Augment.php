<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Augment extends Model
{
    use HasFactory;

    protected $fillable = ['id','name', 'description', 'augment_img', 'tier', 'set_version'];

    public const VALID_TIER =['1', '2', '3'];

    public function compos()
    {
        return $this->hasMany(Composition::class);
    }

    public static function getAugmentWithTier($typeTier = null){
        $query = self::query();

        if ($typeTier && !in_array($typeTier, self::VALID_TIER)) {
            return response()->json(['error' => 'Invalid type value.'], 400);
        }
        
        if ($typeTier) {
            $query->where('tier', $typeTier);
        }

        return $query->get();

    }

}
