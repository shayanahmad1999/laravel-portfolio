<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\SiteSettings;

class PageController extends Controller
{
    public function home()
    {
        $about = About::where('user_id', auth()->id())->first() ?? new About();
        $settings = SiteSettings::where('user_id', auth()->id())->first() ?? new SiteSettings();
        
        return view('pages.home', [
            'title' => 'Home',
            'about' => $about,
            'settings' => $settings
        ]);
    }

    public function contact()
    {
        $settings = SiteSettings::where('user_id', auth()->id())->first() ?? new SiteSettings();
        
        return view('pages.contact', [
            'title' => 'Contact',
            'settings' => $settings
        ]);
    }
}
