<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['name', 'slug', 'is_active'])]
class Category extends Model
{
    public function tickets(): BelongsToMany
    {
        return $this->belongsToMany(Ticket::class);
    }

    public function scopeActive(Builder $builder)
    {
        return $builder->where('is_active', true);
    }
}
