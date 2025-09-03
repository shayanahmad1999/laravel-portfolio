<?php

namespace App\Models;

use App\Traits\UserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory, UserScope;

    protected $fillable = ['name', 'level', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
