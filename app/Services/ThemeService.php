<?php

namespace App\Services;

use App\Models\SiteSettings;

class ThemeService
{
    /**
     * Generate dynamic CSS based on site settings
     *
     * @return string
     */
    public static function generateCss()
    {
        $settings = SiteSettings::first() ?? new SiteSettings();
        
        // Default values if settings are not set
        $primaryColor = $settings->primary_color ?? '#4F46E5';
        $secondaryColor = $settings->secondary_color ?? '#818CF8';
        $accentColor = $settings->accent_color ?? '#F59E0B';
        $buttonColor = $settings->button_color ?? '#4F46E5';
        $buttonHoverColor = $settings->button_hover_color ?? '#4338CA';
        $textColor = $settings->text_color ?? '#111827';
        $navbarColor = $settings->navbar_color ?? '#FFFFFF';
        $navbarTextColor = $settings->navbar_text_color ?? '#111827';
        $footerColor = $settings->footer_color ?? '#1F2937';
        $footerTextColor = $settings->footer_text_color ?? '#F9FAFB';
        
        // Generate CSS
        $css = ":root {\n";
        $css .= "  --primary-color: {$primaryColor};\n";
        $css .= "  --secondary-color: {$secondaryColor};\n";
        $css .= "  --accent-color: {$accentColor};\n";
        $css .= "  --button-color: {$buttonColor};\n";
        $css .= "  --button-hover-color: {$buttonHoverColor};\n";
        $css .= "  --text-color: {$textColor};\n";
        $css .= "  --navbar-color: {$navbarColor};\n";
        $css .= "  --navbar-text-color: {$navbarTextColor};\n";
        $css .= "  --footer-color: {$footerColor};\n";
        $css .= "  --footer-text-color: {$footerTextColor};\n";
        $css .= "}\n\n";
        
        // Apply CSS variables to elements
        $css .= "/* Apply theme colors */\n";
        $css .= "body { color: var(--text-color); }\n";
        $css .= ".bg-primary { background-color: var(--primary-color) !important; }\n";
        $css .= ".bg-secondary { background-color: var(--secondary-color) !important; }\n";
        $css .= ".bg-accent { background-color: var(--accent-color) !important; }\n";
        $css .= ".text-primary { color: var(--primary-color) !important; }\n";
        $css .= ".text-secondary { color: var(--secondary-color) !important; }\n";
        $css .= ".text-accent { color: var(--accent-color) !important; }\n";
        $css .= ".border-primary { border-color: var(--primary-color) !important; }\n";
        $css .= ".border-secondary { border-color: var(--secondary-color) !important; }\n";
        $css .= ".border-accent { border-color: var(--accent-color) !important; }\n\n";
        
        // Buttons
        $css .= "/* Buttons */\n";
        $css .= ".btn-primary {\n";
        $css .= "  background-color: var(--button-color) !important;\n";
        $css .= "  color: white !important;\n";
        $css .= "}\n";
        $css .= ".btn-primary:hover {\n";
        $css .= "  background-color: var(--button-hover-color) !important;\n";
        $css .= "}\n\n";
        
        // Navbar
        $css .= "/* Navbar */\n";
        $css .= "header.site-header {\n";
        $css .= "  background-color: var(--navbar-color) !important;\n";
        $css .= "}\n";
        $css .= "header.site-header .nav-link {\n";
        $css .= "  color: var(--navbar-text-color) !important;\n";
        $css .= "}\n\n";
        
        // Footer
        $css .= "/* Footer */\n";
        $css .= "footer {\n";
        $css .= "  background-color: var(--footer-color) !important;\n";
        $css .= "  color: var(--footer-text-color) !important;\n";
        $css .= "}\n";
        $css .= "footer a {\n";
        $css .= "  color: var(--footer-text-color) !important;\n";
        $css .= "}\n";
        
        return $css;
    }
}