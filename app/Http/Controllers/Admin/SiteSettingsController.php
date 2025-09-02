<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SiteSettingsController extends Controller
{
    /**
     * Display the site settings form.
     */
    public function index()
    {
        $settings = SiteSettings::first() ?? new SiteSettings();
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update the site settings.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'site_title' => 'required|string|max:255',
            'site_description' => 'nullable|string|max:255',
            'primary_color' => 'required|string|max:20',
            'secondary_color' => 'required|string|max:20',
            'accent_color' => 'required|string|max:20',
            'button_color' => 'required|string|max:20',
            'button_hover_color' => 'required|string|max:20',
            'text_color' => 'required|string|max:20',
            'navbar_color' => 'required|string|max:20',
            'navbar_text_color' => 'required|string|max:20',
            'footer_color' => 'required|string|max:20',
            'footer_text_color' => 'required|string|max:20',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'contact_address' => 'nullable|string|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.settings.index')
                ->withErrors($validator)
                ->withInput();
        }

        $settings = SiteSettings::first();
        
        if ($settings) {
            $settings->update($request->all());
        } else {
            SiteSettings::create($request->all());
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Site settings updated successfully.');
    }
}