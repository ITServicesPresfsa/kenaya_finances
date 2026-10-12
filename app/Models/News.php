<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class News extends Model
{
    protected $fillable = [
        'title', 'slug', 'excerpt', 'content', 'featured_image',
        'category_id', 'status', 'published_at', 'meta_title', 'meta_description',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    // ── Relations ──────────────────────────────────────────────────────────────
    public function category(): BelongsTo
    {
        return $this->belongsTo(NewsCategory::class, 'category_id');
    }

    // ── Scopes ─────────────────────────────────────────────────────────────────
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderByDesc('published_at');
    }

    public function scopeDraft(Builder $query): Builder
    {
        return $query->where('status', 'draft');
    }

    // ── Accessors ──────────────────────────────────────────────────────────────
    public function getFeaturedImageUrlAttribute(): string
    {
        if ($this->featured_image) {
            return asset('storage/'.$this->featured_image);
        }

        return asset('images/news-placeholder.jpg');
    }

    public function getReadingTimeAttribute(): int
    {
        $words = str_word_count(strip_tags($this->content));

        return (int) ceil($words / 200);
    }

    public function getMetaTitleAttribute($value): string
    {
        return $value ?: ($this->title.' — Kenaya Finances');
    }

    public function getMetaDescriptionAttribute($value): string
    {
        return $value ?: ($this->excerpt ?: substr(strip_tags($this->content), 0, 160));
    }

    // ── Slug generation helper ─────────────────────────────────────────────────
    public static function generateSlug(string $title, ?int $excludeId = null): string
    {
        $slug = Str::slug($title, '-');
        $original = $slug;
        $counter = 1;

        while (true) {
            $query = static::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
            if (! $query->exists()) {
                break;
            }
            $slug = $original.'-'.$counter++;
        }

        return $slug;
    }
}
