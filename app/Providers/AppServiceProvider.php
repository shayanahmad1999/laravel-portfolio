<?php

namespace App\Providers;

use App\Support\PortfolioContext;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('pages.layouts.app', function ($view) {
            $data = $view->getData();
            $request = request();
            $routeUsername = $request->route('username');
            $isPortfolioRoute = $request->routeIs('portfolio.*');
            $user = $data['portfolioOwner'] ?? null;

            if (!$user) {
                $user = PortfolioContext::resolveUser($request, is_string($routeUsername) ? $routeUsername : null);
            }

            $view->with([
                'activePortfolioUser' => $data['activePortfolioUser'] ?? $user,
                'portfolioOwner' => $data['portfolioOwner'] ?? ($isPortfolioRoute ? $user : null),
                'settings' => $data['settings'] ?? PortfolioContext::settings($user),
                'userId' => $data['userId'] ?? $user?->id,
                'isPublicView' => $data['isPublicView'] ?? !auth()->check(),
            ]);
        });
    }
}

