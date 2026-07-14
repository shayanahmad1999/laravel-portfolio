<?php

namespace App\Http\Controllers;

use App\Services\ThemeService;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    /**
     * Serve the dynamic CSS based on site settings.
     */
    public function css(Request $request)
    {
        $css = ThemeService::generateCss($request->integer('user_id') ?: null);
        
        return response($css)->header('Content-Type', 'text/css');
    }
}
