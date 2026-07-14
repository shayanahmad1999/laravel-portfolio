<?php

namespace App\Models;

use App\Traits\UserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory, UserScope;

    protected $fillable = [
        'user_id',
        'title',
        'icon',
        'accent_color',
        'description',
        'features',
        'is_visible',
        'sort_order',
    ];

    protected $casts = [
        'features' => 'array',
        'is_visible' => 'boolean',
        'sort_order' => 'integer',
    ];
}
