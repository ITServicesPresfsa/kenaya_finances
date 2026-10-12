<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NewsCategory extends Model
{
    protected $fillable = ['name', 'slug'];

    public function news(): HasMany
    {
        return $this->hasMany(News::class, 'category_id');
    }

    public function publishedNews(): HasMany
    {
        return $this->hasMany(News::class, 'category_id')
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }
}
