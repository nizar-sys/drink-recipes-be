<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrinkRecipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'ingredient',
        'step',
        'image',
        'purchase_link',
        'total_view',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault();
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%' . $search . '%');
    }

    public function scopeCategory($query, $category)
    {
        return $query->where('category_id', $category);
    }

    public function scopePopular($query)
    {
        return $query->orderBy('total_view', 'desc');
    }

    public function comments()
    {
        return $this->hasMany(CommentRecipe::class, 'recipe_id')->parent();
    }
}
