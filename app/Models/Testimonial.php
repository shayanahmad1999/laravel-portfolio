<?php

namespace App\Models;

use App\Traits\UserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory, UserScope;

    protected $fillable = [
        'user_id',
        'client_name',
        'client_role',
        'client_company',
        'avatar',
        'rating',
        'message',
        'is_visible',
        'sort_order',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'rating' => 'integer',
        'sort_order' => 'integer',
    ];
}
