<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone',
        'subject', 'message', 'is_treated', 'ip_address',
    ];

    protected $casts = [
        'is_treated' => 'boolean',
    ];

    public function scopeUntreated(Builder $query): Builder
    {
        return $query->where('is_treated', false);
    }

    public function getFullNameAttribute(): string
    {
        return trim($this->first_name.' '.$this->last_name);
    }
}
