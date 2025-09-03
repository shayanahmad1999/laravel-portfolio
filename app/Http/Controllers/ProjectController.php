<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function page(Request $request)
    {
        $userId = $this->resolveUserId($request);
        
        $categories = Category::query()
            ->when($userId, fn($query) => $query->where('user_id', $userId))
            ->orderBy('name')
            ->get();
            
        return view('pages.projects', [
            'title' => 'Projects', 
            'categories' => $categories,
            'userId' => $userId,
            'isPublicView' => !Auth::check()
        ]);
    }
    
    /**
     * Show projects page for a specific user's portfolio
     */
    public function publicPage($username)
    {
        $user = User::where('portfolio_slug', $username)
                   ->orWhere('name', $username)
                   ->orWhere('email', $username)
                   ->firstOrFail();
                   
        // Check if portfolio is public
        if (isset($user->is_portfolio_public) && !$user->is_portfolio_public && !\Illuminate\Support\Facades\Auth::check()) {
            abort(403, 'This portfolio is private');
        }
                   
        $categories = Category::where('user_id', $user->id)
            ->orderBy('name')
            ->get();
            
        return view('pages.projects', [
            'title' => $user->name . "'s Projects",
            'categories' => $categories,
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
        // Check if a specific user is requested
        if ($request->has('user_id')) {
            return $request->get('user_id');
        }
        
        // If user is authenticated, show their portfolio
        if (Auth::check()) {
            return Auth::id();
        }
        
        // If no user is authenticated, check if there's a demo user
        $demoUser = User::first();
        return $demoUser ? $demoUser->id : null;
    }
}
