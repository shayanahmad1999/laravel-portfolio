<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\SiteSettings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function home(Request $request)
    {
        $userId = $this->resolveUserId($request);
        
        if ($userId) {
            $about = About::where('user_id', $userId)->first() ?? new About();
            $settings = SiteSettings::where('user_id', $userId)->first() ?? new SiteSettings();
        } else {
            // Show default/demo content when no user is specified
            $about = new About();
            $settings = new SiteSettings();
        }

        return view('pages.home', [
            'title' => 'Home',
            'about' => $about,
            'settings' => $settings,
            'userId' => $userId,
            'isPublicView' => !Auth::check()
        ]);
    }

    public function contact(Request $request)
    {
        $userId = $this->resolveUserId($request);
        
        if ($userId) {
            $settings = SiteSettings::where('user_id', $userId)->first() ?? new SiteSettings();
        } else {
            $settings = new SiteSettings();
        }

        return view('pages.contact', [
            'title' => 'Contact',
            'settings' => $settings,
            'userId' => $userId,
            'isPublicView' => !Auth::check()
        ]);
    }
    
    /**
     * Show a specific user's portfolio
     */
    public function portfolio($username)
    {
        $user = User::where('portfolio_slug', $username)
                   ->orWhere('name', $username)
                   ->orWhere('email', $username)
                   ->firstOrFail();
                   
        // Check if portfolio is public (optional privacy feature)
        if (isset($user->is_portfolio_public) && !$user->is_portfolio_public && !Auth::check()) {
            abort(403, 'This portfolio is private');
        }
                   
        $about = About::where('user_id', $user->id)->first() ?? new About();
        $settings = SiteSettings::where('user_id', $user->id)->first() ?? new SiteSettings();
        
        return view('pages.home', [
            'title' => $user->name . "'s Portfolio",
            'about' => $about,
            'settings' => $settings,
            'userId' => $user->id,
            'portfolioOwner' => $user,
            'isPublicView' => true
        ]);
    }
    
    /**
     * Resolve which user's portfolio to show
     */
    private function resolveUserId(Request $request)
    {
        // If user is authenticated, show their portfolio
        if (Auth::check()) {
            return Auth::id();
        }
        
        // If no user is authenticated, check if there's a demo user
        // You can modify this logic based on your needs
        $demoUser = User::first();
        return $demoUser ? $demoUser->id : null;
    }
    
    /**
     * Show contact page for a specific user's portfolio
     */
    public function publicContact($username)
    {
        $user = User::where('portfolio_slug', $username)
                   ->orWhere('name', $username)
                   ->orWhere('email', $username)
                   ->firstOrFail();
                   
        // Check if portfolio is public
        if (isset($user->is_portfolio_public) && !$user->is_portfolio_public && !Auth::check()) {
            abort(403, 'This portfolio is private');
        }
                   
        $settings = SiteSettings::where('user_id', $user->id)->first() ?? new SiteSettings();
        
        return view('pages.contact', [
            'title' => 'Contact ' . $user->name,
            'settings' => $settings,
            'userId' => $user->id,
            'portfolioOwner' => $user,
            'isPublicView' => true
        ]);
    }
}
