<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\SiteSettings;

class PageController extends Controller
{
    public function home()
    {
        $about = About::first() ?? new About();
        $settings = SiteSettings::first() ?? new SiteSettings();
        
        return view('pages.home', [
            'title' => 'Home',
            'about' => $about,
            'settings' => $settings
        ]);
    }

    public function contact()
    {
        $settings = SiteSettings::first() ?? new SiteSettings();
        
        return view('pages.contact', [
            'title' => 'Contact',
            'settings' => $settings
        ]);
    }
}
