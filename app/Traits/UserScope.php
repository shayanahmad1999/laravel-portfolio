<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait UserScope
{
    public function getUserId(): ?int
    {
        return Auth::id();
    }

    public function scopeByUserId(Builder $query, string $column = 'user_id'): Builder
    {
        return $query->where($column, $this->getUserId());
    }
}
