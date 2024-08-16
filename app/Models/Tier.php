<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tier extends Model
{
    use HasFactory;

    public function composition()
    {
        return $this->hasOne(Composition::class);
    }

    public function item()
    {
        return $this->hasOne(Item::class);
    }

    public function augment()
    {
        return $this->hasOne(Augment::class);
    }
}
