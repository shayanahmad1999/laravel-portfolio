@extends('pages.layouts.app')

@section('content')
    <div class="fade-in-scroll">
        <div class="mb-12 text-center">
            <h1
                class="text-5xl font-bold mb-4 bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent inline-block reveal-text">
                My Projects</h1>
            <p class="text-gray-600 max-w-2xl mx-auto reveal-text" style="animation-delay: 0.2s">Explore my portfolio of web
                development projects showcasing my skills in frontend and backend technologies</p>
        </div>

        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 mb-12 fade-in-scroll card-hover-effect"
            style="animation-delay: 0.3s">
            <div class="flex flex-col md:flex-row gap-6 items-end">
                <div class="w-full md:w-1/3">
                    <label for="cat" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select id="cat"
                        class="form-input bg-white hover-lift rounded-lg border-gray-200 w-full focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all">
                        <option value="">All categories</option>
                        @foreach ($categories as $c)
                            <option value="{{ $c->name }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full md:w-1/3">
                    <label for="q" class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <input id="q"
                        class="form-input hover-lift rounded-lg border-gray-200 w-full focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all"
                        placeholder="Search by title...">
                </div>

                <div class="w-full md:w-auto">
                    <button id="go"
                        class="btn-primary w-full md:w-auto btn-pulse hover-lift px-6 py-3 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium flex items-center justify-center gap-2 transition-all hover:shadow-lg">
                        <i class="fas fa-filter"></i> Filter Projects
                    </button>
                </div>
            </div>
        </div>

        <div id="loading" class="py-16 text-center hidden">
            <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-3 border-b-3 border-indigo-600"></div>
            <p class="mt-4 text-gray-600 font-medium">Loading amazing projects...</p>
        </div>

        <div id="grid" class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8" data-stagger="container"></div>

        <div class="mt-12 flex justify-center" id="pager"></div>
    </div>

    <script>
        const STORAGE_URL = "{{ asset('storage') }}";
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize scroll animations
            initScrollAnimations();

            // Initialize staggered animations
            initStaggeredAnimations();

            // Add floating animation to elements
            addFloatingAnimation();
        });

        const grid = document.getElementById('grid');
        const pager = document.getElementById('pager');
        const cat = document.getElementById('cat');
        const q = document.getElementById('q');
        const loading = document.getElementById('loading');
        const filterBtn = document.getElementById('go');

        async function load(url = '{{ route('ajax.projects') }}') {
            // Show loading indicator
            grid.innerHTML = '';
            pager.innerHTML = '';
            loading.classList.remove('hidden');

            const params = new URLSearchParams();
            if (cat.value) params.set('category', cat.value);
            if (q.value) params.set('search', q.value);
            @if(isset($userId) && $userId)
                params.set('user_id', '{{ $userId }}');
            @endif

            try {
                const res = await fetch(url + '?' + params.toString(), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = await res.json();

                // Hide loading indicator
                loading.classList.add('hidden');

                if (data.data.length === 0) {
                    grid.innerHTML = `
        <div class="col-span-full text-center py-16 fade-in-scroll bg-white rounded-2xl shadow-sm border border-gray-100 card-hover-effect">
          <div class="text-6xl mb-6 text-indigo-200 floating"><i class="fas fa-folder-open"></i></div>
          <h3 class="text-2xl font-medium mb-3">No projects found</h3>
          <p class="text-gray-500 max-w-md mx-auto">We couldn't find any projects matching your criteria. Try adjusting your filters or search terms.</p>
        </div>
      `;
                    return;
                }

                grid.innerHTML = data.data.map((p, index) => `
      <article class="project-card rounded-2xl overflow-hidden bg-white shadow-sm hover:shadow-xl card-hover-effect stagger-item" style="transition-delay: ${index * 0.1}s;">
        ${p.thumbnail ? `<div class="relative overflow-hidden h-56">
                          <img src="${STORAGE_URL}/${p.thumbnail}" class="w-full h-full object-cover img-hover-zoom" alt="${p.title}">
                          ${p.category ? `<span class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm text-xs px-3 py-1.5 rounded-full text-indigo-600 font-medium shadow-sm">${p.category}</span>` : ''}
                        </div>` : ``}
        <div class="p-8">
          <h3 class="font-bold text-2xl mb-3 text-gray-800">${p.title}</h3>
          <p class="text-gray-600 mb-5 line-clamp-2">${p.excerpt ?? ''}</p>
          ${p.tags ? `<div class="flex flex-wrap gap-2 mb-6">
                            ${Array.isArray(p.tags) ? p.tags.map(tag => `<span class="bg-indigo-50 text-indigo-600 text-xs px-3 py-1.5 rounded-full hover-scale font-medium">${tag}</span>`).join('') : ''}
                          </div>` : ''}
          <div class="flex gap-4">
            ${p.live_url ? `<a class="px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg text-sm font-medium hover:shadow-lg transition-all flex items-center gap-2 btn-pulse" href="${p.live_url}" target="_blank"><i class="fas fa-external-link-alt"></i> View Live</a>` : ``}
            ${p.repo_url ? `<a class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-all flex items-center gap-2 hover-lift" href="${p.repo_url}" target="_blank"><i class="fab fa-github"></i> View Code</a>` : ``}
          </div>
        </div>
      </article>
    `).join('');

                // Initialize staggered animations after loading projects
                initStaggeredAnimations();

                // Create pagination if available
                if (data.links && data.links.length > 3) {
                    pager.innerHTML = `<div class="inline-flex rounded-md shadow-sm">
        ${data.links.map(link => {
          if (link.url === null) return '';
          return `<button class="${link.active ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700'} px-4 py-2 text-sm font-medium border ${link.active ? 'border-indigo-600' : 'border-gray-300'} ${link.label.includes('Previous') ? 'rounded-l-lg' : ''} ${link.label.includes('Next') ? 'rounded-r-lg' : ''} hover:bg-gray-50 ${link.active ? 'hover:bg-indigo-700' : ''} hover-lift"
                            ${link.url ? `onclick="load('${link.url}')"` : 'disabled'}
                          >${link.label.replace('&laquo;', '<i class="fas fa-chevron-left"></i>').replace('&raquo;', '<i class="fas fa-chevron-right"></i>')}</button>`;
        }).join('')}
      </div>`;
                }
            } catch (error) {
                loading.classList.add('hidden');
                grid.innerHTML = `
      <div class="col-span-full text-center py-12 fade-in-scroll">
        <div class="text-5xl mb-4 text-red-500 floating"><i class="fas fa-exclamation-circle"></i></div>
        <h3 class="text-xl font-medium mb-2">Error loading projects</h3>
        <p class="text-gray-500">Please try again later</p>
      </div>
    `;
            }
        }

        document.getElementById('go').addEventListener('click', () => load());
        document.addEventListener('DOMContentLoaded', () => {
            load();

            // Initialize scroll animations
            initScrollAnimations();

            // Add floating animation to elements
            addFloatingAnimation();
        });
    </script>
@endsection
