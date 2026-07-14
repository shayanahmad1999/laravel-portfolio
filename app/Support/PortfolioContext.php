<?php

namespace App\Support;

use App\Models\About;
use App\Models\SiteSettings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortfolioContext
{
    public static function userFromPublicIdentifier(string $identifier): User
    {
        $user = User::where('portfolio_slug', $identifier)
            ->orWhere('name', $identifier)
            ->orWhere('email', $identifier)
            ->firstOrFail();

        self::abortIfPrivate($user);

        return $user;
    }

    public static function resolveUser(Request $request, ?string $identifier = null): ?User
    {
        if ($identifier) {
            return self::userFromPublicIdentifier($identifier);
        }

        if ($request->filled('user_id')) {
            return User::find($request->integer('user_id'));
        }

        if (Auth::check()) {
            return Auth::user();
        }

        return User::first();
    }

    public static function settings(?User $user): SiteSettings
    {
        return $user
            ? SiteSettings::where('user_id', $user->id)->first() ?? new SiteSettings()
            : new SiteSettings();
    }

    public static function about(?User $user): About
    {
        return $user
            ? About::where('user_id', $user->id)->first() ?? new About()
            : new About();
    }

    public static function publicRouteParam(User $user): string
    {
        return $user->portfolio_slug ?: $user->name;
    }

    public static function isCustomSiteTitle(?SiteSettings $settings): bool
    {
        $title = trim((string) ($settings->site_title ?? ''));

        return $title !== '' && strcasecmp($title, 'My Portfolio') !== 0;
    }

    private static function abortIfPrivate(User $user): void
    {
        $isOwner = Auth::check() && Auth::id() === $user->id;

        if (!$isOwner && isset($user->is_portfolio_public) && !$user->is_portfolio_public) {
            abort(403, 'This portfolio is private');
        }
    }
}
