<?php

namespace App\Models;

use App\Traits\UserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimelineEntry extends Model
{
    use HasFactory, UserScope;

    protected $fillable = [
        'user_id',
        'title',
        'organization',
        'entry_type',
        'start_date',
        'end_date',
        'is_current',
        'description',
        'is_visible',
        'sort_order',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
        'is_visible' => 'boolean',
        'sort_order' => 'integer',
    ];
}
