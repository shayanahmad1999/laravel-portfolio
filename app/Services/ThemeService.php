<?php

namespace App\Services;

use App\Models\SiteSettings;
use Illuminate\Support\Facades\Auth;

class ThemeService
{
    /**
     * Generate dynamic CSS based on site settings.
     */
    public static function generateCss(?int $userId = null): string
    {
        $resolvedUserId = $userId ?: Auth::id();

        $settings = $resolvedUserId
            ? SiteSettings::where('user_id', $resolvedUserId)->first()
            : SiteSettings::first();

        $settings = $settings ?? new SiteSettings();
        
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
        
        $css .= ".btn-primary {\n";
        $css .= "  background: var(--button-color) !important;\n";
        $css .= "  color: white !important;\n";
        $css .= "}\n";
        $css .= ".btn-primary:hover {\n";
        $css .= "  background: var(--button-hover-color) !important;\n";
        $css .= "}\n\n";
        
        $css .= "header.site-header {\n";
        $css .= "  background-color: var(--navbar-color) !important;\n";
        $css .= "}\n";
        $css .= "header.site-header a {\n";
        $css .= "  color: var(--navbar-text-color) !important;\n";
        $css .= "}\n\n";
        
        $css .= "footer {\n";
        $css .= "  background-color: var(--footer-color) !important;\n";
        $css .= "  color: var(--footer-text-color) !important;\n";
        $css .= "}\n";
        $css .= "footer, footer p, footer li, footer h3, footer i, footer a {\n";
        $css .= "  color: var(--footer-text-color) !important;\n";
        $css .= "}\n";
        
        return $css;
    }
}
