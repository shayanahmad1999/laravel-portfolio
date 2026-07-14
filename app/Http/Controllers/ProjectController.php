<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Support\PortfolioContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function page(Request $request)
    {
        $user = PortfolioContext::resolveUser($request);
        $userId = $user?->id;
        
        $categories = Category::query()
            ->when($userId, fn($query) => $query->where('user_id', $userId))
            ->orderBy('name')
            ->get();
            
        return view('pages.projects', [
            'title' => 'Projects', 
            'categories' => $categories,
            'settings' => PortfolioContext::settings($user),
            'userId' => $userId,
            'portfolioOwner' => $request->routeIs('portfolio.*') ? $user : null,
            'isPublicView' => !Auth::check(),
        ]);
    }

    public function publicPage(string $username)
    {
        $user = PortfolioContext::userFromPublicIdentifier($username);
        $settings = PortfolioContext::settings($user);
                   
        $categories = Category::where('user_id', $user->id)
            ->orderBy('name')
            ->get();
            
        return view('pages.projects', [
            'title' => PortfolioContext::isCustomSiteTitle($settings) ? $settings->site_title . ' Projects' : $user->name . "'s Projects",
            'categories' => $categories,
            'settings' => $settings,
            'userId' => $user->id,
            'portfolioOwner' => $user,
            'isPublicView' => true,
        ]);
    }
}
