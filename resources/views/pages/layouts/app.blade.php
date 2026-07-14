<!doctype html>
<html lang="en">
@php
    $brandOwner = $portfolioOwner ?? ($activePortfolioUser ?? auth()->user());
    $brandTitle = \App\Support\PortfolioContext::isCustomSiteTitle($settings ?? null)
        ? $settings->site_title
        : ($brandOwner ? $brandOwner->name . "'s Portfolio" : 'My Portfolio');
    $brandHref = isset($portfolioOwner)
        ? route('portfolio.public', \App\Support\PortfolioContext::publicRouteParam($portfolioOwner))
        : route('home');
@endphp

<head>
    <meta charset="utf-8">
    <title>{{ $brandTitle ?? ($title ?? 'Portfolio') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ isset($settings) && $settings->site_description ? $settings->site_description : 'My Portfolio Website' }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/css/custom.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ route('theme.css', ['user_id' => $userId ?? ($activePortfolioUser->id ?? null)]) }}">
    <script src="/js/animations.js" defer></script>
</head>

<body class="bg-gray-50 text-gray-800" style="font-family: 'Poppins', sans-serif;">

    <header class="site-header sticky top-0 z-50 bg-white shadow-sm transition-all">
        <nav class="mx-auto max-w-6xl px-4 py-4 flex items-center justify-between">
            <a href="{{ $brandHref }}" class="font-bold text-xl bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent hover-scale">
                {{ $brandTitle }}
            </a>
            <ul class="flex gap-8">
                @if(isset($portfolioOwner))
                    <li><a href="{{ route('portfolio.public', \App\Support\PortfolioContext::publicRouteParam($portfolioOwner)) }}" class="text-gray-700 hover:text-indigo-600 animated-underline transition-colors {{ request()->routeIs('portfolio.public') ? 'text-indigo-600' : '' }}">Home</a></li>
                    <li><a href="{{ route('portfolio.projects', \App\Support\PortfolioContext::publicRouteParam($portfolioOwner)) }}" class="text-gray-700 hover:text-indigo-600 animated-underline transition-colors {{ request()->routeIs('portfolio.projects') ? 'text-indigo-600' : '' }}">Projects</a></li>
                    <li><a href="{{ route('portfolio.contact', \App\Support\PortfolioContext::publicRouteParam($portfolioOwner)) }}" class="text-gray-700 hover:text-indigo-600 animated-underline transition-colors {{ request()->routeIs('portfolio.contact') ? 'text-indigo-600' : '' }}">Contact</a></li>
                @else
                    <li><a href="{{ route('home') }}" class="text-gray-700 hover:text-indigo-600 animated-underline transition-colors {{ request()->routeIs('home') ? 'text-indigo-600' : '' }}">Home</a></li>
                    <li><a href="{{ route('projects.page') }}" class="text-gray-700 hover:text-indigo-600 animated-underline transition-colors {{ request()->routeIs('projects.page') ? 'text-indigo-600' : '' }}">Projects</a></li>
                    <li><a href="{{ route('contact.page') }}" class="text-gray-700 hover:text-indigo-600 animated-underline transition-colors {{ request()->routeIs('contact.page') ? 'text-indigo-600' : '' }}">Contact</a></li>
                @endif
            </ul>
        </nav>
    </header>

    <main class="mx-auto max-w-6xl px-4 py-12">
        @yield('content')
    </main>

    <footer class="mx-auto max-w-6xl px-4 py-12 border-t border-gray-100">
        <div class="grid md:grid-cols-3 gap-8">
            <div>
                <h3 class="font-bold text-xl mb-4 bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">{{ $brandTitle }}</h3>
                <p class="text-gray-600 mb-4">{{ isset($settings) && $settings->site_description ? $settings->site_description : 'A showcase of my work and skills in web development.' }}</p>
                <div class="flex gap-4">
                    @if(isset($settings) && $settings->github_url)
                    <a href="{{ $settings->github_url }}" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-indigo-600 hover:text-white transition-colors hover-scale">
                        <i class="fab fa-github"></i>
                    </a>
                    @endif
                    @if(isset($settings) && $settings->linkedin_url)
                    <a href="{{ $settings->linkedin_url }}" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-indigo-600 hover:text-white transition-colors hover-scale">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    @endif
                    @if(isset($settings) && $settings->twitter_url)
                    <a href="{{ $settings->twitter_url }}" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-indigo-600 hover:text-white transition-colors hover-scale">
                        <i class="fab fa-twitter"></i>
                    </a>
                    @endif
                    @if(isset($settings) && $settings->facebook_url)
                    <a href="{{ $settings->facebook_url }}" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-indigo-600 hover:text-white transition-colors hover-scale">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    @endif
                    @if(isset($settings) && $settings->instagram_url)
                    <a href="{{ $settings->instagram_url }}" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-indigo-600 hover:text-white transition-colors hover-scale">
                        <i class="fab fa-instagram"></i>
                    </a>
                    @endif
                    @if(isset($settings) && $settings->whatsapp_url)
                    <a href="{{ $settings->whatsapp_url }}" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-indigo-600 hover:text-white transition-colors hover-scale">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    @endif
                </div>
            </div>
            <div>
                <h3 class="font-bold mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    @if(isset($portfolioOwner))
                        <li><a href="{{ route('portfolio.public', \App\Support\PortfolioContext::publicRouteParam($portfolioOwner)) }}" class="text-gray-600 hover:text-indigo-600 transition-colors">Home</a></li>
                        <li><a href="{{ route('portfolio.projects', \App\Support\PortfolioContext::publicRouteParam($portfolioOwner)) }}" class="text-gray-600 hover:text-indigo-600 transition-colors">Projects</a></li>
                        <li><a href="{{ route('portfolio.contact', \App\Support\PortfolioContext::publicRouteParam($portfolioOwner)) }}" class="text-gray-600 hover:text-indigo-600 transition-colors">Contact</a></li>
                    @else
                        <li><a href="{{ route('home') }}" class="text-gray-600 hover:text-indigo-600 transition-colors">Home</a></li>
                        <li><a href="{{ route('projects.page') }}" class="text-gray-600 hover:text-indigo-600 transition-colors">Projects</a></li>
                        <li><a href="{{ route('contact.page') }}" class="text-gray-600 hover:text-indigo-600 transition-colors">Contact</a></li>
                    @endif
                </ul>
            </div>
            <div>
                <h3 class="font-bold mb-4">Contact</h3>
                <ul class="space-y-2 text-gray-600">
                    @if(isset($settings) && $settings->contact_email)
                        <li class="flex items-center gap-2"><i class="fas fa-envelope text-indigo-600"></i> {{ $settings->contact_email }}</li>
                    @endif
                    @if(isset($settings) && $settings->contact_phone)
                        <li class="flex items-center gap-2"><i class="fas fa-phone text-indigo-600"></i> {{ $settings->contact_phone }}</li>
                    @endif
                    @if(isset($settings) && $settings->contact_address)
                        <li class="flex items-center gap-2"><i class="fas fa-map-marker-alt text-indigo-600"></i> {{ $settings->contact_address }}</li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="mt-8 pt-8 border-t border-gray-100 text-center text-sm text-gray-500">
            © {{ date('Y') }} — Built with Laravel + AJAX
        </div>
    </footer>
</body>

</html>

