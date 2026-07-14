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
                    <label for="featuredOnly" class="mb-2 flex items-center gap-2 text-sm font-medium text-gray-700 md:justify-center">
                        <input type="checkbox" id="featuredOnly" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        Featured only
                    </label>
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

    <div id="projectModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-gray-900/70 px-4 py-8">
        <div class="relative max-h-[90vh] w-full max-w-4xl overflow-y-auto rounded-2xl bg-white shadow-2xl">
            <button type="button" id="closeProjectModal"
                class="absolute right-4 top-4 z-10 flex h-10 w-10 items-center justify-center rounded-full bg-white/90 text-gray-600 shadow hover:bg-gray-100"
                aria-label="Close project details">
                <i class="fas fa-times"></i>
            </button>
            <div id="projectModalContent"></div>
        </div>
    </div>

    <script>
        const STORAGE_URL = "{{ asset('storage') }}";
        const projectsBySlug = new Map();

        const grid = document.getElementById('grid');
        const pager = document.getElementById('pager');
        const cat = document.getElementById('cat');
        const q = document.getElementById('q');
        const loading = document.getElementById('loading');
        const featuredOnly = document.getElementById('featuredOnly');
        const projectModal = document.getElementById('projectModal');
        const projectModalContent = document.getElementById('projectModalContent');

        function escapeHtml(value) {
            return String(value ?? '').replace(/[&<>'"]/g, character => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                "'": '&#039;',
                '"': '&quot;'
            }[character]));
        }

        function nl2br(value) {
            return escapeHtml(value).replace(/\n/g, '<br>');
        }

        function renderProjectGallery(images, compact = false) {
            if (!Array.isArray(images) || images.length === 0) return '';

            return `
              <div class="${compact ? 'mb-6' : 'mt-8'}">
                ${!compact ? `<h4 class="mb-4 font-semibold text-gray-800">Project Gallery</h4>` : ''}
                <div class="grid ${compact ? 'grid-cols-3' : 'grid-cols-2 md:grid-cols-3'} gap-2">
                  ${images.slice(0, compact ? 6 : images.length).map(image => `<a href="${STORAGE_URL}/${image.path}" target="_blank" class="block overflow-hidden rounded-lg border border-gray-100 bg-gray-50">
                    <img src="${STORAGE_URL}/${image.path}" alt="${escapeHtml(image.name || 'Project screenshot')}" class="${compact ? 'h-20' : 'h-28 md:h-36'} w-full object-cover transition-transform hover:scale-105">
                  </a>`).join('')}
                </div>
              </div>
            `;
        }

        function renderProjectFiles(files, compact = false) {
            if (!Array.isArray(files) || files.length === 0) return '';

            const imageFiles = files.filter(file => file.mime && file.mime.startsWith('image/'));
            const documentFiles = files.filter(file => !file.mime || !file.mime.startsWith('image/'));
            const imageHeight = compact ? 'h-20' : 'h-28 md:h-36';

            return `
              <div class="${compact ? 'mb-6' : 'mt-8'} space-y-4">
                ${!compact ? `<h4 class="font-semibold text-gray-800">Project Files</h4>` : ''}
                ${imageFiles.length ? `<div class="grid ${compact ? 'grid-cols-3' : 'grid-cols-2 md:grid-cols-3'} gap-2">
                  ${imageFiles.slice(0, compact ? 6 : imageFiles.length).map(file => `<a href="${STORAGE_URL}/${file.path}" target="_blank" class="block overflow-hidden rounded-lg border border-gray-100 bg-gray-50">
                    <img src="${STORAGE_URL}/${file.path}" alt="${escapeHtml(file.name || 'Project file')}" class="${imageHeight} w-full object-cover transition-transform hover:scale-105">
                  </a>`).join('')}
                </div>` : ''}
                ${documentFiles.length ? `<div class="space-y-2">
                  ${documentFiles.map(file => `<a href="${STORAGE_URL}/${file.path}" target="_blank" class="flex items-center gap-2 rounded-lg bg-gray-50 px-3 py-2 text-sm text-gray-700 transition-colors hover:bg-gray-100">
                    <i class="fas fa-file-alt text-indigo-500"></i>
                    <span class="truncate">${escapeHtml(file.name || 'Project file')}</span>
                  </a>`).join('')}
                </div>` : ''}
              </div>
            `;
        }

        function renderProjectActions(project, includeDetailsButton = true) {
            return `
                <div class="flex flex-wrap gap-3">
                    ${includeDetailsButton ? `<button type="button" class="px-5 py-2.5 bg-indigo-50 text-indigo-700 rounded-lg text-sm font-medium hover:bg-indigo-100 transition-all flex items-center gap-2 hover-lift" onclick="openProjectModal('${escapeHtml(project.slug)}')"><i class="fas fa-circle-info"></i> Details</button>` : ''}
                    ${project.live_url ? `<a class="px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg text-sm font-medium hover:shadow-lg transition-all flex items-center gap-2 btn-pulse" href="${escapeHtml(project.live_url)}" target="_blank"><i class="fas fa-external-link-alt"></i> View Live</a>` : ``}
                    ${project.repo_url ? `<a class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-all flex items-center gap-2 hover-lift" href="${escapeHtml(project.repo_url)}" target="_blank"><i class="fab fa-github"></i> View Code</a>` : ``}
                </div>
            `;
        }

        function openProjectModal(slug) {
            const project = projectsBySlug.get(slug);
            if (!project) return;

            projectModalContent.innerHTML = `
                ${project.thumbnail ? `<div class="h-64 md:h-80 overflow-hidden rounded-t-2xl bg-gray-100"><img src="${STORAGE_URL}/${project.thumbnail}" alt="${escapeHtml(project.title)}" class="h-full w-full object-cover"></div>` : ''}
                <div class="p-8">
                    <div class="mb-4 flex flex-wrap items-center gap-3">
                        ${project.is_featured ? `<span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-medium text-amber-800"><i class="fas fa-star mr-1"></i>Featured</span>` : ''}
                        ${project.category ? `<span class="rounded-full bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-600">${escapeHtml(project.category)}</span>` : ''}
                        ${Array.isArray(project.project_files) && project.project_files.length ? `<span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600"><i class="fas fa-paperclip mr-1"></i>${project.project_files.length} file${project.project_files.length === 1 ? '' : 's'}</span>` : ''}
                    </div>
                    <h2 class="mb-4 text-3xl font-bold text-gray-900">${escapeHtml(project.title)}</h2>
                    <div class="prose max-w-none text-gray-600 leading-relaxed">${nl2br(project.body || project.excerpt || '')}</div>
                    ${project.tags ? `<div class="mt-6 flex flex-wrap gap-2">
                        ${Array.isArray(project.tags) ? project.tags.map(tag => `<span class="bg-indigo-50 text-indigo-600 text-xs px-3 py-1.5 rounded-full font-medium">${escapeHtml(tag)}</span>`).join('') : ''}
                    </div>` : ''}
                    ${renderProjectGallery(project.gallery_images, false)}
                    ${renderProjectFiles(project.project_files, false)}
                    <div class="mt-8">${renderProjectActions(project, false)}</div>
                </div>
            `;

            projectModal.classList.remove('hidden');
            projectModal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }

        function closeProjectModal() {
            projectModal.classList.add('hidden');
            projectModal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }

        async function load(url = '{{ route('ajax.projects') }}') {
            grid.innerHTML = '';
            pager.innerHTML = '';
            loading.classList.remove('hidden');

            const params = new URLSearchParams();
            if (cat.value) params.set('category', cat.value);
            if (q.value) params.set('search', q.value);
            if (featuredOnly.checked) params.set('featured', '1');
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

                loading.classList.add('hidden');
                projectsBySlug.clear();

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

                data.data.forEach(project => projectsBySlug.set(project.slug, project));

                grid.innerHTML = data.data.map((p, index) => `
      <article class="project-card rounded-2xl overflow-hidden bg-white shadow-sm hover:shadow-xl card-hover-effect stagger-item" style="transition-delay: ${index * 0.1}s;">
        ${p.thumbnail ? `<div class="relative overflow-hidden h-56">
                          <img src="${STORAGE_URL}/${p.thumbnail}" class="w-full h-full object-cover img-hover-zoom" alt="${escapeHtml(p.title)}">
                          ${p.is_featured ? `<span class="absolute left-4 top-4 bg-amber-100/95 backdrop-blur-sm text-xs px-3 py-1.5 rounded-full text-amber-800 font-medium shadow-sm"><i class="fas fa-star mr-1"></i>Featured</span>` : ''}
                          ${p.category ? `<span class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm text-xs px-3 py-1.5 rounded-full text-indigo-600 font-medium shadow-sm">${escapeHtml(p.category)}</span>` : ''}
                        </div>` : ``}
        <div class="p-8">
          <h3 class="font-bold text-2xl mb-3 text-gray-800">${escapeHtml(p.title)}</h3>
          <p class="text-gray-600 mb-5 line-clamp-2">${escapeHtml(p.excerpt ?? '')}</p>
          ${p.tags ? `<div class="flex flex-wrap gap-2 mb-6">
                            ${Array.isArray(p.tags) ? p.tags.map(tag => `<span class="bg-indigo-50 text-indigo-600 text-xs px-3 py-1.5 rounded-full hover-scale font-medium">${escapeHtml(tag)}</span>`).join('') : ''}
                          </div>` : ''}
          ${renderProjectGallery(p.gallery_images, true)}
          ${renderProjectFiles(p.project_files, true)}
          ${renderProjectActions(p)}
        </div>
      </article>
    `).join('');

                initStaggeredAnimations();

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
        featuredOnly.addEventListener('change', () => load());
        document.getElementById('closeProjectModal').addEventListener('click', closeProjectModal);
        projectModal.addEventListener('click', (event) => {
            if (event.target === projectModal) closeProjectModal();
        });
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') closeProjectModal();
        });

        document.addEventListener('DOMContentLoaded', () => {
            load();
            initScrollAnimations();
            addFloatingAnimation();
        });
    </script>
@endsection

