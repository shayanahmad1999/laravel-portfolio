<?php

namespace App\Models;

use App\Traits\UserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory, UserScope;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content',
        'image',
        'resume_link',
        'years_experience',
        'completed_projects',
        'companies_worked',
        'user_id',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}