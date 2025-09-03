<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PortfolioController extends Controller
{
    /**
     * Generate a shareable link for the authenticated user's portfolio
     */
    public function generateShareLink(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Authentication required'], 401);
        }

        $user = Auth::user();
        
        // If user doesn't have a portfolio slug, generate one
        if (empty($user->portfolio_slug)) {
            $user->portfolio_slug = $this->generateUniqueSlug($user->name);
            $user->save();
        }

        $shareUrl = route('portfolio.public', ['username' => $user->portfolio_slug]);
        
        return response()->json([
            'share_url' => $shareUrl,
            'portfolio_slug' => $user->portfolio_slug
        ]);
    }
    
    /**
     * Update portfolio visibility settings
     */
    public function updateVisibility(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Authentication required'], 401);
        }

        $request->validate([
            'is_portfolio_public' => 'required|boolean'
        ]);

        $user = Auth::user();
        $user->is_portfolio_public = $request->is_portfolio_public;
        $user->save();

        return response()->json(['success' => true]);
    }
    
    /**
     * Get portfolio sharing info
     */
    public function getSharingInfo()
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Authentication required'], 401);
        }

        $user = Auth::user();
        
        return response()->json([
            'is_public' => $user->is_portfolio_public ?? false,
            'portfolio_slug' => $user->portfolio_slug,
            'share_url' => $user->portfolio_slug ? route('portfolio.public', ['username' => $user->portfolio_slug]) : null
        ]);
    }
    
    /**
     * Generate a unique slug for portfolio URL
     */
    private function generateUniqueSlug($name)
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;
        
        while (User::where('portfolio_slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }
}
