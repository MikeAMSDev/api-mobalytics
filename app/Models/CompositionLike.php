<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompositionLike extends Model
{
    use HasFactory;

    protected $fillable = ['id','composition_id', 'user_id','type']; 
}
