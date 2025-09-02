<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} Admin - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Custom Admin CSS -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .sidebar {
            transition: all 0.3s ease;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.open {
                transform: translateX(0);
            }
        }
        
        .nav-link {
            transition: all 0.2s ease;
        }
        
        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            border-left: 4px solid white;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="sidebar fixed inset-y-0 left-0 z-50 w-64 bg-indigo-800 text-white shadow-lg md:relative md:translate-x-0">
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="flex items-center justify-between p-4 border-b border-indigo-700">
                    <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold">Portfolio Admin</a>
                    <button id="closeSidebar" class="md:hidden text-white focus:outline-none">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <!-- Navigation -->
                <nav class="flex-1 px-2 py-4 space-y-1 overflow-y-auto">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link flex items-center px-4 py-2 rounded-md {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        <span>Dashboard</span>
                    </a>
                    
                    <a href="{{ route('admin.projects.index') }}" class="nav-link flex items-center px-4 py-2 rounded-md {{ request()->routeIs('admin.projects*') ? 'active' : '' }}">
                        <i class="fas fa-project-diagram mr-3"></i>
                        <span>Projects</span>
                    </a>
                    
                    <a href="{{ route('admin.skills.index') }}" class="nav-link flex items-center px-4 py-2 rounded-md {{ request()->routeIs('admin.skills*') ? 'active' : '' }}">
                        <i class="fas fa-code mr-3"></i>
                        <span>Skills</span>
                    </a>
                    
                    <a href="{{ route('admin.categories.index') }}" class="nav-link flex items-center px-4 py-2 rounded-md {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                        <i class="fas fa-tags mr-3"></i>
                        <span>Categories</span>
                    </a>
                    
                    <div class="pt-4 mt-4 border-t border-indigo-700">
                        <a href="{{ route('home') }}" class="nav-link flex items-center px-4 py-2 rounded-md" target="_blank">
                            <i class="fas fa-external-link-alt mr-3"></i>
                            <span>View Site</span>
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}" class="mt-1">
                            @csrf
                            <button type="submit" class="nav-link w-full flex items-center px-4 py-2 rounded-md text-left">
                                <i class="fas fa-sign-out-alt mr-3"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navbar -->
            <header class="bg-white shadow-sm z-10">
                <div class="flex items-center justify-between p-4">
                    <button id="openSidebar" class="md:hidden focus:outline-none">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <span class="text-sm text-gray-700">{{ Auth::user()->name }}</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                <!-- Page Heading -->
                <div class="mb-6">
                    <h1 class="text-2xl font-semibold text-gray-800">@yield('title', 'Dashboard')</h1>
                    @if(isset($breadcrumbs))
                        <div class="text-sm text-gray-500 mt-1">
                            {{ $breadcrumbs }}
                        </div>
                    @endif
                </div>
                
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif
                
                <!-- Content -->
                @yield('content')
            </main>
        </div>
    </div>
    
    <script>
        // Mobile sidebar toggle
        document.getElementById('openSidebar').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.add('open');
        });
        
        document.getElementById('closeSidebar').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.remove('open');
        });
    </script>
</body>
</html>