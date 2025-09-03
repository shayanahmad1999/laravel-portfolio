<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSettings extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'site_title',
        'site_description',
        'primary_color',
        'secondary_color',
        'accent_color',
        'button_color',
        'button_hover_color',
        'text_color',
        'navbar_color',
        'navbar_text_color',
        'footer_color',
        'footer_text_color',
        'contact_email',
        'contact_phone',
        'contact_address',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'linkedin_url',
        'github_url',
        'user_id',
    ];

    /**
     * Get a setting value by key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get a setting value by key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        $setting = self::first();
        
        if (!$setting) {
            return $default;
        }
        
        return $setting->$key ?? $default;
    }
}