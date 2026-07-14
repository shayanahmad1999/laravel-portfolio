@extends('pages.layouts.app')

@section('content')
    @php
        $publicParam = isset($portfolioOwner) && $portfolioOwner ? \App\Support\PortfolioContext::publicRouteParam($portfolioOwner) : null;
        $projectsUrl = $publicParam ? route('portfolio.projects', $publicParam) : route('projects.page');
        $contactUrl = $publicParam ? route('portfolio.contact', $publicParam) : route('contact.page');
        $resumeUrl = isset($settings) && $settings->resume_file ? asset('storage/' . $settings->resume_file) : (isset($about) && $about->resume_link ? $about->resume_link : null);
        $socialLinks = [
            ['url' => $settings->github_url ?? null, 'icon' => 'fab fa-github', 'label' => 'GitHub'],
            ['url' => $settings->linkedin_url ?? null, 'icon' => 'fab fa-linkedin-in', 'label' => 'LinkedIn'],
            ['url' => $settings->twitter_url ?? null, 'icon' => 'fab fa-twitter', 'label' => 'Twitter'],
            ['url' => $settings->instagram_url ?? null, 'icon' => 'fab fa-instagram', 'label' => 'Instagram'],
            ['url' => $settings->facebook_url ?? null, 'icon' => 'fab fa-facebook-f', 'label' => 'Facebook'],
            ['url' => $settings->whatsapp_url ?? null, 'icon' => 'fab fa-whatsapp', 'label' => 'WhatsApp'],
        ];
    @endphp
    <!-- Hero Section -->
    <section class="py-20 md:py-28">
        <div class="grid md:grid-cols-2 gap-16 items-center">
            <div class="fade-in-scroll">
                <div class="inline-block px-4 py-1 bg-indigo-50 text-indigo-700 rounded-full mb-6 reveal-text">
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-indigo-600 rounded-full mr-2"></div>
                        <span
                            class="text-sm font-medium">{{ isset($settings->hero_tagline) ? $settings->hero_tagline : 'Full Stack Developer' }}</span>
                    </div>
                </div>
                <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight reveal-text">
                    <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                        {{ isset($settings->hero_title) ? $settings->hero_title : 'Hi, I\'m ' . (config('app.name') ?? 'Developer') }}
                    </span>
                </h1>
                <p class="text-xl text-gray-600 mb-8 leading-relaxed fade-in-scroll max-w-lg">
                    {{ isset($settings->hero_description) ? $settings->hero_description : 'I build beautiful, responsive web applications with modern technologies and creative solutions.' }}
                </p>
                <div class="flex flex-wrap gap-4 fade-in-scroll" style="transition-delay: 0.3s;">
                    <a href="{{ $projectsUrl }}"
                        class="btn-primary flex items-center gap-2 btn-pulse px-8 py-4 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium transition-all hover:shadow-lg">
                        <span>View Projects</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="{{ $contactUrl }}"
                        class="px-8 py-4 rounded-xl border-2 border-indigo-600 text-indigo-600 font-medium hover:bg-indigo-50 transition-all duration-300 hover-lift flex items-center gap-2">
                        <i class="fas fa-envelope"></i>
                        <span>Contact Me</span>
                    </a>
                </div>

                <div class="mt-12 flex items-center gap-6 fade-in-scroll" style="transition-delay: 0.5s;">
                    <div class="flex -space-x-4">
                        <img class="w-10 h-10 rounded-full border-2 border-white"
                            src="https://randomuser.me/api/portraits/men/32.jpg" alt="User">
                        <img class="w-10 h-10 rounded-full border-2 border-white"
                            src="https://randomuser.me/api/portraits/women/31.jpg" alt="User">
                        <img class="w-10 h-10 rounded-full border-2 border-white"
                            src="https://randomuser.me/api/portraits/men/33.jpg" alt="User">
                    </div>
                    <div class="text-sm">
                        <span class="text-gray-800 font-medium">50+ clients</span>
                        <div class="flex items-center text-yellow-500">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <span class="text-gray-600 ml-1">5.0 (24 reviews)</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="fade-in-scroll hidden md:block" style="transition-delay: 0.2s;">
                <div class="relative">
                    <div class="absolute -top-10 -left-10 w-32 h-32 bg-indigo-100 rounded-full floating opacity-70"></div>
                    <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-purple-100 rounded-full floating opacity-70"
                        style="animation-delay: 1s;"></div>
                    <div class="absolute top-1/2 right-0 transform translate-x-1/2 -translate-y-1/2 w-20 h-20 bg-yellow-100 rounded-full floating opacity-70"
                        style="animation-delay: 1.5s;"></div>
                    <div class="relative z-10 bg-white rounded-2xl shadow-xl p-8 border border-gray-100 hover-scale">
                        <div
                            class="absolute top-4 right-4 bg-indigo-50 text-indigo-600 px-3 py-1 rounded-full text-xs font-medium">
                            Available for hire</div>
                        <div class="img-hover-zoom">
                            <img src="/images/neat.png" alt="Portfolio" class="w-full h-auto rounded-lg mb-6">
                        </div>
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="font-bold text-lg animated-underline">
                                    {{ isset($settings->hero_title) ? $settings->hero_title : 'Web Developer' }}</h3>
                                <p class="text-gray-500">
                                    {{ isset($settings->hero_tagline) ? $settings->hero_tagline : 'Full Stack Developer' }}
                                </p>
                            </div>
                            <div>
                                <div
                                    class="w-12 h-12 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-full flex items-center justify-center text-white floating shadow-lg">
                                    <i class="fas fa-code"></i>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 pt-6 border-t border-gray-100">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                                        <i class="fas fa-check text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium">Available</span>
                                </div>
                                <a href="{{ $contactUrl }}"
                                    class="text-indigo-600 text-sm font-medium hover:underline">Let's Talk <i
                                        class="fas fa-arrow-right ml-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Skills Section -->
    <section
        class="py-20 bg-white rounded-3xl shadow-sm border border-gray-100 my-16 fade-in-scroll relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-50 rounded-full -mr-32 -mt-32 opacity-70"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-purple-50 rounded-full -ml-32 -mb-32 opacity-70"></div>

        <div class="relative z-10">
            <div class="text-center mb-16">
                <div class="inline-block px-4 py-1 bg-indigo-50 text-indigo-700 rounded-full mb-4 reveal-text">
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-indigo-600 rounded-full mr-2"></div>
                        <span class="text-sm font-medium">Professional Skills</span>
                    </div>
                </div>
                <h2 class="text-4xl font-bold mb-4 animated-gradient">My Expertise</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Here are some of the technologies and tools I work with</p>
            </div>

            <div id="skills-container" class="max-w-4xl mx-auto px-6" data-stagger="container">
                <!-- Skills will be loaded here -->
            </div>
        </div>
    </section>

    <!-- About Me Section -->
    <section class="py-20 fade-in-scroll">
        <div class="grid md:grid-cols-2 gap-16 items-center">
            <div class="fade-in-scroll">
                <div class="inline-block px-4 py-1 bg-indigo-50 text-indigo-700 rounded-full mb-4 reveal-text">
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-indigo-600 rounded-full mr-2"></div>
                        <span class="text-sm font-medium">About Me</span>
                    </div>
                </div>
                <h2 class="text-4xl font-bold mb-6 animated-gradient">
                    {{ isset($about) && $about->title ? $about->title : 'Who I Am' }}</h2>
                <div class="text-gray-600 mb-8 leading-relaxed">
                    {!! isset($about) && $about->content
                        ? $about->content
                        : 'I am a passionate web developer with experience in creating modern, responsive web applications.' !!}
                </div>

                <div class="grid grid-cols-3 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center hover-lift">
                        <div class="text-3xl font-bold text-indigo-600 mb-2">
                            {{ isset($about) && $about->years_experience ? $about->years_experience : '5+' }}</div>
                        <div class="text-gray-600 text-sm">Years Experience</div>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center hover-lift">
                        <div class="text-3xl font-bold text-indigo-600 mb-2">
                            {{ isset($about) && $about->completed_projects ? $about->completed_projects : '100+' }}</div>
                        <div class="text-gray-600 text-sm">Projects Done</div>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center hover-lift">
                        <div class="text-3xl font-bold text-indigo-600 mb-2">
                            {{ isset($about) && $about->companies_worked ? $about->companies_worked : '12+' }}</div>
                        <div class="text-gray-600 text-sm">Companies</div>
                    </div>
                </div>

                @if ($resumeUrl)
                    <a href="{{ $resumeUrl }}" target="_blank"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-50 text-indigo-700 rounded-xl hover:bg-indigo-100 transition-colors">
                        <i class="fas fa-file-pdf"></i>
                        <span>Download Resume</span>
                    </a>
                @endif
            </div>

            <div class="fade-in-scroll hidden md:block" style="transition-delay: 0.2s;">
                <div class="relative">
                    <div class="absolute -top-10 -left-10 w-32 h-32 bg-indigo-100 rounded-full floating opacity-70"></div>
                    <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-purple-100 rounded-full floating opacity-70"
                        style="animation-delay: 1s;"></div>
                    <div class="img-hover-zoom rounded-2xl overflow-hidden shadow-xl border border-gray-100">
                        @if (isset($about) && $about->image)
                            <img src="{{ asset('storage/' . $about->image) }}" alt="About Me" class="w-full h-auto">
                        @else
                            <img src="/images/neat.png" alt="About Me" class="w-full h-auto">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-20 fade-in-scroll">
        <div class="text-center mb-16">
            <div class="inline-block px-4 py-1 bg-indigo-50 text-indigo-700 rounded-full mb-4 reveal-text">
                <div class="flex items-center">
                    <div class="w-2 h-2 bg-indigo-600 rounded-full mr-2"></div>
                    <span class="text-sm font-medium">My Services</span>
                </div>
            </div>
            <h2 class="text-4xl font-bold mb-4 animated-gradient">What I Do</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Services I offer to my clients</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8" data-stagger="container">
            <div
                class="bg-white p-10 rounded-2xl shadow-sm border border-gray-100 card-hover-effect stagger-item relative overflow-hidden group">
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-full -mr-16 -mt-16 opacity-0 group-hover:opacity-70 transition-opacity duration-500">
                </div>
                <div class="relative z-10">
                    <div
                        class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center text-indigo-600 mb-8 floating shadow-md">
                        <i class="fas fa-laptop-code text-xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Web Development</h3>
                    <p class="text-gray-600 mb-6">Creating responsive, modern websites and web applications with the latest
                        technologies.</p>
                    <ul class="space-y-2 text-gray-600">
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            <span>Custom Website Development</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            <span>E-commerce Solutions</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            <span>Web Application Development</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div
                class="bg-white p-10 rounded-2xl shadow-sm border border-gray-100 card-hover-effect stagger-item relative overflow-hidden group">
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-purple-50 rounded-full -mr-16 -mt-16 opacity-0 group-hover:opacity-70 transition-opacity duration-500">
                </div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center text-purple-600 mb-8 floating shadow-md"
                        style="animation-delay: 0.5s;">
                        <i class="fas fa-mobile-alt text-xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Responsive Design</h3>
                    <p class="text-gray-600 mb-6">Building interfaces that work beautifully on all devices, from mobile to
                        desktop.
                    </p>
                    <ul class="space-y-2 text-gray-600">
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            <span>Mobile-First Approach</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            <span>Cross-Browser Compatibility</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            <span>UI/UX Optimization</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div
                class="bg-white p-10 rounded-2xl shadow-sm border border-gray-100 card-hover-effect stagger-item relative overflow-hidden group">
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-full -mr-16 -mt-16 opacity-0 group-hover:opacity-70 transition-opacity duration-500">
                </div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 mb-8 floating shadow-md"
                        style="animation-delay: 1s;">
                        <i class="fas fa-server text-xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Backend Development</h3>
                    <p class="text-gray-600 mb-6">Creating robust server-side applications with Laravel and other modern
                        frameworks.
                    </p>
                    <ul class="space-y-2 text-gray-600">
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            <span>API Development</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            <span>Database Design</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            <span>Authentication & Security</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>


    @if(isset($timelineEntries) && $timelineEntries->count())
        <section class="py-20 fade-in-scroll">
            <div class="text-center mb-16">
                <div class="inline-block px-4 py-1 bg-indigo-50 text-indigo-700 rounded-full mb-4 reveal-text">
                    <span class="text-sm font-medium">Journey</span>
                </div>
                <h2 class="text-4xl font-bold mb-4 animated-gradient">Experience & Education</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">A quick view of my professional path, learning, and achievements.</p>
            </div>

            <div class="max-w-4xl mx-auto space-y-6">
                @foreach($timelineEntries as $entry)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover-lift">
                        <div class="flex flex-col gap-3 md:flex-row md:items-start md:justify-between">
                            <div>
                                <span class="inline-flex rounded-full bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-700 capitalize">{{ $entry->entry_type }}</span>
                                <h3 class="mt-3 text-xl font-bold text-gray-900">{{ $entry->title }}</h3>
                                @if($entry->organization)
                                    <p class="text-gray-600">{{ $entry->organization }}</p>
                                @endif
                            </div>
                            <div class="text-sm font-medium text-gray-500 md:text-right">
                                {{ optional($entry->start_date)->format('M Y') ?: 'Anytime' }} - {{ $entry->is_current ? 'Present' : (optional($entry->end_date)->format('M Y') ?: 'Now') }}
                            </div>
                        </div>
                        @if($entry->description)
                            <p class="mt-4 leading-relaxed text-gray-600">{{ $entry->description }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    @if(isset($testimonials) && $testimonials->count())
        <section class="py-20 fade-in-scroll">
            <div class="text-center mb-16">
                <div class="inline-block px-4 py-1 bg-indigo-50 text-indigo-700 rounded-full mb-4 reveal-text">
                    <span class="text-sm font-medium">Testimonials</span>
                </div>
                <h2 class="text-4xl font-bold mb-4 animated-gradient">What People Say</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Feedback from people I have worked with.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                @foreach($testimonials as $testimonial)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 hover-lift">
                        <div class="mb-5 flex items-center gap-4">
                            @if($testimonial->avatar)
                                <img src="{{ asset('storage/' . $testimonial->avatar) }}" alt="{{ $testimonial->client_name }}" class="h-14 w-14 rounded-full object-cover">
                            @else
                                <div class="h-14 w-14 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600"><i class="fas fa-user"></i></div>
                            @endif
                            <div>
                                <h3 class="font-bold text-gray-900">{{ $testimonial->client_name }}</h3>
                                <p class="text-sm text-gray-500">{{ trim(($testimonial->client_role ?? '') . ($testimonial->client_company ? ' at ' . $testimonial->client_company : '')) }}</p>
                            </div>
                        </div>
                        <div class="mb-4 text-yellow-500">@for($i = 0; $i < $testimonial->rating; $i++)<i class="fas fa-star"></i>@endfor</div>
                        <p class="leading-relaxed text-gray-600">{{ $testimonial->message }}</p>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    @if(collect($socialLinks)->whereNotNull('url')->count())
        <section class="py-12 fade-in-scroll">
            <div class="flex flex-wrap items-center justify-center gap-4">
                @foreach($socialLinks as $social)
                    @if($social['url'])
                        <a href="{{ $social['url'] }}" target="_blank" class="flex h-12 w-12 items-center justify-center rounded-full bg-white text-indigo-600 shadow-sm border border-gray-100 hover:bg-indigo-50 hover-lift" aria-label="{{ $social['label'] }}">
                            <i class="{{ $social['icon'] }}"></i>
                        </a>
                    @endif
                @endforeach
            </div>
        </section>
    @endif

    <!-- Call to Action Section -->
    <section
        class="py-20 my-16 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-3xl text-white fade-in-scroll relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full -mr-48 -mt-48"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-black/10 rounded-full -ml-48 -mb-48"></div>

        <div class="relative z-10 max-w-4xl mx-auto text-center px-6">
            <h2 class="text-4xl font-bold mb-6 reveal-text">Ready to Start Your Project?</h2>
            <p class="text-xl mb-10 opacity-90 max-w-2xl mx-auto reveal-text" style="animation-delay: 0.2s;">Let's
                collaborate to bring your ideas to life with modern web technologies and creative solutions.</p>
            <div class="flex flex-wrap justify-center gap-6">
                <a href="{{ $projectsUrl }}"
                    class="px-8 py-4 bg-white text-indigo-600 font-medium rounded-xl hover:bg-opacity-90 transition-all hover-lift btn-pulse flex items-center gap-2">
                    <i class="fas fa-eye"></i>
                    <span>View My Work</span>
                </a>
                <a href="{{ $contactUrl }}"
                    class="px-8 py-4 bg-transparent border-2 border-white text-white font-medium rounded-xl hover:bg-white/10 transition-all hover-lift flex items-center gap-2">
                    <i class="fas fa-paper-plane"></i>
                    <span>Contact Me</span>
                </a>
            </div>
        </div>
    </section>

    <script>
        const STORAGE_URL = "{{ asset('storage') }}";

        function escapeHtml(value) {
            return String(value ?? '').replace(/[&<>'"]/g, character => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                "'": '&#039;',
                '"': '&quot;'
            }[character]));
        }

        document.addEventListener('DOMContentLoaded', async () => {
            // Fetch and render skills
            let skillsUrl = '{{ route('ajax.skills') }}';
            @if(isset($userId) && $userId)
                skillsUrl += '?user_id={{ $userId }}';
            @endif
            const res = await fetch(skillsUrl);
            const skills = await res.json();
            const container = document.getElementById('skills-container');

            container.innerHTML = skills.map((skill, index) => `
    <div class="mb-8 stagger-item" style="transition-delay: ${index * 0.1}s;">
      <div class="flex justify-between items-center mb-3 gap-4">
        <div class="flex min-w-0 items-center">
          <div class="w-10 h-10 rounded-lg bg-indigo-50 flex shrink-0 items-center justify-center text-indigo-600 mr-3 overflow-hidden border border-indigo-100">
            ${skill.logo ? `<img src="${STORAGE_URL}/${skill.logo}" alt="${escapeHtml(skill.name)}" class="h-full w-full object-contain p-1">` : `<i class="fas ${getIconForSkill(skill.name)}"></i>`}
          </div>
          <span class="font-medium text-lg truncate">${escapeHtml(skill.name)}</span>
        </div>
        <span class="text-sm font-medium px-3 py-1 bg-indigo-50 text-indigo-700 rounded-full shrink-0">${skill.level}%</span>
      </div>
      <div class="skill-bar h-3 bg-gray-100 rounded-full overflow-hidden">
        <div class="skill-progress h-full rounded-full bg-gradient-to-r from-indigo-600 to-purple-600" style="width: 0%" data-width="${skill.level}%"></div>
      </div>
    </div>
  `).join('');

            // Initialize scroll animations
            initScrollAnimations();

            // Initialize staggered animations
            initStaggeredAnimations();

            // Add floating animation to elements
            addFloatingAnimation();

            // Animate skill bars when they come into view
            setTimeout(() => {
                animateSkillBars();
            }, 500);
        });

        // Helper function to animate skill bars
        function animateSkillBars() {
            const skillBars = document.querySelectorAll('.skill-bar');

            skillBars.forEach(bar => {
                const position = bar.getBoundingClientRect();

                if (position.top < window.innerHeight * 0.9) {
                    const progressBar = bar.querySelector('.skill-progress');
                    if (progressBar && progressBar.dataset.width) {
                        progressBar.style.width = progressBar.dataset.width;
                    }
                }
            });
        }

        // Helper function to get appropriate icon for each skill
        function getIconForSkill(skillName) {
            const skillIcons = {
                'HTML': 'fa-html5',
                'CSS': 'fa-css3-alt',
                'JavaScript': 'fa-js',
                'PHP': 'fa-php',
                'Laravel': 'fa-laravel',
                'React': 'fa-react',
                'Vue.js': 'fa-vuejs',
                'Node.js': 'fa-node-js',
                'MySQL': 'fa-database',
                'MongoDB': 'fa-database',
                'Git': 'fa-git-alt',
                'Docker': 'fa-docker',
                'AWS': 'fa-aws',
                'Python': 'fa-python',
                'TypeScript': 'fa-code',
                'Angular': 'fa-angular',
                'Bootstrap': 'fa-bootstrap',
                'Tailwind': 'fa-wind',
                'jQuery': 'fa-code',
                'WordPress': 'fa-wordpress',
                'Figma': 'fa-figma',
                'Photoshop': 'fa-image',
                'Illustrator': 'fa-pen-nib'
            };

            // Return the icon or a default one if not found
            return skillIcons[skillName] || 'fa-code';
        }
    </script>
@endsection



