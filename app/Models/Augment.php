<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Augment extends Model
{
    use HasFactory;

    protected $fillable = ['id','name', 'description', 'augment_img', 'tier', 'set_version'];

    public const VALID_TIER =['1', '2', '3'];

    public function compos()
    {
        return $this->hasMany(Composition::class);
    }

    public static function getAugmentWithTier($typeTier = null)
    {
        $query = self::query();

        if ($typeTier) {
            $query->where('tier', $typeTier);
        }

        return $query->get();
    }

    public static function findOrFailAugments($id)
    {
        $augment = self::find($id);

        if (!$augment) {
            return response()->json('Augment not found', 404);
        }

        return $augment;
    }

    public static function createAugment(array $data)
    {
        return self::create($data);
    }

    public function updateAugment(array $data)
    {
        return $this->update($data);
    }

    public function deleteAugment()
    {
        DB::table('augment_comp')->where('augment_id', $this->id)->delete();

        $this->delete();
    }

}
