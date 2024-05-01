<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentRecipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipe_id',
        'user_id',
        'parent_id',
        'comment',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function recipe()
    {
        return $this->belongsTo(DrinkRecipe::class, 'recipe_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function parent()
    {
        return $this->belongsTo(CommentRecipe::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(CommentRecipe::class, 'parent_id');
    }

    public function scopeParent($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeChild($query)
    {
        return $query->whereNotNull('parent_id');
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeOldest($query)
    {
        return $query->orderBy('created_at', 'asc');
    }
}
