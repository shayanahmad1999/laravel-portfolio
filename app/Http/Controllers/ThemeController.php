<?php

namespace App\Http\Controllers;

use App\Services\ThemeService;

class ThemeController extends Controller
{
    /**
     * Serve the dynamic CSS based on site settings
     *
     * @return \Illuminate\Http\Response
     */
    public function css()
    {
        $css = ThemeService::generateCss();
        
        return response($css)->header('Content-Type', 'text/css');
    }
}