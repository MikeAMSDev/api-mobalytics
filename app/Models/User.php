<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'id', 'name', 'email', 'password', 'remember_token', 'roles_id'
    ];

    public function compos()
    {
        return $this->hasMany(Composition::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function validateAction($action)
    {
        $validActions = ['like', 'dislike', 'undo'];
        return in_array($action, $validActions);
    }

    public function toggleAction(Composition $composition, $action)
    {
        if (!$this->validateAction($action)) {
            throw new \Exception('Invalid action.');
        }

        if ($action === 'like') {
            if ($this->hasDisliked($composition)) {
                $this->undoLikeOrDislike($composition);
                $this->like($composition);
            } elseif (!$this->hasLiked($composition)) {
                $this->like($composition);
            }
        } elseif ($action === 'dislike') {
            if ($this->hasLiked($composition)) {
                $this->undoLikeOrDislike($composition);
                $this->dislike($composition);
            } elseif (!$this->hasDisliked($composition)) {
                $this->dislike($composition);
            }
        } elseif ($action === 'undo') {
            if ($this->hasLiked($composition) || $this->hasDisliked($composition)) {
                $this->undoLikeOrDislike($composition);
            }
        }
    }

    
    public function like(Composition $composition)
    {

        $this->compositionLikes()->where('composition_id', $composition->id)->delete();

        $this->compositionLikes()->create([
            'composition_id' => $composition->id,
            'type' => 'like'
        ]);

        $composition->addLike();
    }
    
    public function dislike(Composition $composition)
    {

        $this->compositionLikes()->where('composition_id', $composition->id)->delete();

        $this->compositionLikes()->create([
            'composition_id' => $composition->id,
            'type' => 'dislike'
        ]);

        $composition->removeLike();
    }

    public function undoLikeOrDislike(Composition $composition)
    {
        $likeOrDislike = $this->compositionLikes()->where('composition_id', $composition->id)->first();

        if ($likeOrDislike) {
            if ($likeOrDislike->type === 'like') {
                $composition->removeLike();
            } elseif ($likeOrDislike->type === 'dislike') {
                $composition->addLike();
            }

            $likeOrDislike->delete();
        }
    }

    public function hasLiked(Composition $composition)
    {
        return $this->compositionLikes()->where('composition_id', $composition->id)->where('type', 'like')->exists();
    }
    
    public function hasDisliked(Composition $composition)
    {
        return $this->compositionLikes()->where('composition_id', $composition->id)->where('type', 'dislike')->exists();
    }
    
    public function compositionLikes()
    {
        return $this->hasMany(CompositionLike::class);
    }
}