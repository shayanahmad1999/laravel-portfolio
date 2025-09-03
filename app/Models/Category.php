<?php

namespace App\Models;

use App\Traits\UserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, UserScope;

    protected $fillable = ['name', 'user_id'];

    public function projects()
    { 
        return $this->hasMany(Project::class); 
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
