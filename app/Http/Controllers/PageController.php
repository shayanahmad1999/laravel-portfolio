<?php

namespace App\Http\Controllers;

use App\Models\{Service, Testimonial, TimelineEntry};
use App\Support\PortfolioContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function home(Request $request)
    {
        $user = PortfolioContext::resolveUser($request);
        $settings = PortfolioContext::settings($user);

        return view('pages.home', [
            'title' => 'Home',
            'about' => PortfolioContext::about($user),
            'settings' => $settings,
            'userId' => $user?->id,
            'portfolioOwner' => $request->routeIs('portfolio.*') ? $user : null,
            'isPublicView' => !Auth::check(),
            'testimonials' => $this->testimonials($user?->id),
            'timelineEntries' => $this->timelineEntries($user?->id),
            'services' => $this->services($user?->id),
        ]);
    }

    public function contact(Request $request)
    {
        $user = PortfolioContext::resolveUser($request);

        return view('pages.contact', [
            'title' => 'Contact',
            'settings' => PortfolioContext::settings($user),
            'userId' => $user?->id,
            'portfolioOwner' => $request->routeIs('portfolio.*') ? $user : null,
            'isPublicView' => !Auth::check(),
        ]);
    }

    public function portfolio(string $username)
    {
        $user = PortfolioContext::userFromPublicIdentifier($username);
        $settings = PortfolioContext::settings($user);

        return view('pages.home', [
            'title' => PortfolioContext::isCustomSiteTitle($settings) ? $settings->site_title : $user->name . "'s Portfolio",
            'about' => PortfolioContext::about($user),
            'settings' => $settings,
            'userId' => $user->id,
            'portfolioOwner' => $user,
            'isPublicView' => true,
            'testimonials' => $this->testimonials($user->id),
            'timelineEntries' => $this->timelineEntries($user->id),
            'services' => $this->services($user->id),
        ]);
    }

    public function publicContact(string $username)
    {
        $user = PortfolioContext::userFromPublicIdentifier($username);
        $settings = PortfolioContext::settings($user);

        return view('pages.contact', [
            'title' => PortfolioContext::isCustomSiteTitle($settings) ? 'Contact ' . $settings->site_title : 'Contact ' . $user->name,
            'settings' => $settings,
            'userId' => $user->id,
            'portfolioOwner' => $user,
            'isPublicView' => true,
        ]);
    }

    private function services(?int $userId)
    {
        return Service::query()
            ->when($userId, fn($query) => $query->where('user_id', $userId))
            ->where('is_visible', true)
            ->orderBy('sort_order')
            ->latest()
            ->take(6)
            ->get();
    }

    private function testimonials(?int $userId)
    {
        return Testimonial::query()
            ->when($userId, fn($query) => $query->where('user_id', $userId))
            ->where('is_visible', true)
            ->orderBy('sort_order')
            ->latest()
            ->take(6)
            ->get();
    }

    private function timelineEntries(?int $userId)
    {
        return TimelineEntry::query()
            ->when($userId, fn($query) => $query->where('user_id', $userId))
            ->where('is_visible', true)
            ->orderBy('sort_order')
            ->orderByDesc('start_date')
            ->take(8)
            ->get();
    }
}
