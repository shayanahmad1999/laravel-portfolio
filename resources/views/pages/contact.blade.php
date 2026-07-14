@extends('pages.layouts.app')

@section('content')
    <div class="fade-in-scroll">
        <div class="mb-12 text-center">
            <h1
                class="text-5xl font-bold mb-4 bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent inline-block reveal-text">
                Get In Touch</h1>
            <p class="text-gray-600 mb-8 max-w-2xl mx-auto reveal-text" style="animation-delay: 0.2s">Have a question or want to work together? I'm always open to discussing new projects, creative ideas or opportunities.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-12">
            <div class="bg-white p-10 rounded-2xl shadow-sm border border-gray-100 fade-in-scroll card-hover-effect relative overflow-hidden"
                style="animation-delay: 0.3s">
                <div class="absolute -top-16 -left-16 w-32 h-32 bg-indigo-50 rounded-full opacity-70"></div>
                <div class="absolute -bottom-16 -right-16 w-32 h-32 bg-purple-50 rounded-full opacity-70"></div>
                <div class="relative z-10">
                <form id="contactForm" class="space-y-8">
                    <input type="hidden" name="user_id" value="{{ $userId ?? '' }}">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Your Name</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="fas fa-user"></i>
                            </div>
                            <input name="name" id="name" class="form-input hover-lift pl-10 rounded-lg border-gray-200 w-full focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all" placeholder="John Doe" required>
                        </div>
                        <div class="error-message text-red-500 text-sm mt-2 hidden" id="name-error"></div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <input name="email" id="email" type="email" class="form-input hover-lift pl-10 rounded-lg border-gray-200 w-full focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all"
                                placeholder="john@example.com" required>
                        </div>
                        <div class="error-message text-red-500 text-sm mt-2 hidden" id="email-error"></div>
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                        <div class="relative">
                            <div class="absolute top-3 left-0 pl-3 flex items-start pointer-events-none text-gray-400">
                                <i class="fas fa-comment-alt"></i>
                            </div>
                            <textarea name="message" id="message" class="form-input hover-lift pl-10 rounded-lg border-gray-200 w-full focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all" rows="5" placeholder="Your message here..."
                                required></textarea>
                        </div>
                        <div class="error-message text-red-500 text-sm mt-2 hidden" id="message-error"></div>
                    </div>

                    <div>
                        <button type="submit"
                            class="btn-primary w-full flex items-center justify-center gap-2 btn-pulse hover-lift px-6 py-3 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium transition-all hover:shadow-lg"
                            id="submit-btn">
                            <span>Send Message</span>
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>

                <div id="status-container" class="mt-8 hidden">
                    <div id="success-message"
                        class="bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-lg hidden">
                        <div class="flex items-center">
                            <div class="bg-green-100 p-2 rounded-full mr-3">
                                <i class="fas fa-check-circle text-green-500 text-xl floating"></i>
                            </div>
                            <p id="success-text" class="font-medium"></p>
                        </div>
                    </div>

                    <div id="error-message"
                        class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-lg hidden">
                        <div class="flex items-center">
                            <div class="bg-red-100 p-2 rounded-full mr-3">
                                <i class="fas fa-exclamation-circle text-red-500 text-xl floating"></i>
                            </div>
                            <p id="error-text" class="font-medium"></p>
                        </div>
                    </div>
                </div>
                </div>
            </div>

            <div class="hidden md:block fade-in-scroll" style="animation-delay: 0.5s">
                <div
                    class="bg-gradient-to-br from-indigo-600 to-purple-600 p-10 rounded-2xl text-white h-full flex flex-col justify-between animated-gradient card-hover-effect relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-32 -mt-32"></div>
                    <div class="absolute bottom-0 left-0 w-64 h-64 bg-black/5 rounded-full -ml-32 -mb-32"></div>
                    
                    <div class="relative z-10">
                        <h3 class="text-3xl font-bold mb-6 reveal-text">Let's Connect</h3>
                        <p class="mb-10 text-indigo-100 reveal-text leading-relaxed" style="animation-delay: 0.2s">I'm always open to
                            discussing new projects, creative ideas or opportunities to be part of your vision.</p>

                        <div class="space-y-6" data-stagger="container">
                            <div class="flex items-start stagger-item bg-white/10 p-4 rounded-xl hover-lift">
                                <div class="bg-white/20 p-3 rounded-lg mr-4 floating">
                                    <i class="fas fa-map-marker-alt text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-lg">Location</h4>
                                    <p class="text-indigo-100">{{ isset($settings) && $settings->contact_address ? $settings->contact_address : 'Your City, Country' }}</p>
                                </div>
                            </div>

                            <div class="flex items-start stagger-item bg-white/10 p-4 rounded-xl hover-lift">
                                <div class="bg-white/20 p-3 rounded-lg mr-4 floating" style="animation-delay: 0.5s">
                                    <i class="fas fa-envelope text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-lg">Email</h4>
                                    <p class="text-indigo-100">{{ isset($settings) && $settings->contact_email ? $settings->contact_email : 'contact@example.com' }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start stagger-item bg-white/10 p-4 rounded-xl hover-lift">
                                <div class="bg-white/20 p-3 rounded-lg mr-4 floating" style="animation-delay: 1s">
                                    <i class="fas fa-phone-alt text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-lg">Phone</h4>
                                    <p class="text-indigo-100">{{ isset($settings) && $settings->contact_phone ? $settings->contact_phone : '+1 (123) 456-7890' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-12 relative z-10">
                        <h4 class="font-medium mb-4 text-lg reveal-text">Connect With Me</h4>
                        <div class="flex gap-4" data-stagger="container">
                            @if(isset($settings) && $settings->github_url)
                            <a href="{{ $settings->github_url }}"
                                class="bg-white/20 w-12 h-12 rounded-full flex items-center justify-center hover:bg-white/30 transition-colors hover-scale stagger-item shadow-lg">
                                <i class="fab fa-github text-lg"></i>
                            </a>
                            @endif
                            @if(isset($settings) && $settings->linkedin_url)
                            <a href="{{ $settings->linkedin_url }}"
                                class="bg-white/20 w-12 h-12 rounded-full flex items-center justify-center hover:bg-white/30 transition-colors hover-scale stagger-item shadow-lg">
                                <i class="fab fa-linkedin-in text-lg"></i>
                            </a>
                            @endif
                            @if(isset($settings) && $settings->twitter_url)
                            <a href="{{ $settings->twitter_url }}"
                                class="bg-white/20 w-12 h-12 rounded-full flex items-center justify-center hover:bg-white/30 transition-colors hover-scale stagger-item shadow-lg">
                                <i class="fab fa-twitter text-lg"></i>
                            </a>
                            @endif
                            @if(isset($settings) && $settings->instagram_url)
                            <a href="{{ $settings->instagram_url }}"
                                class="bg-white/20 w-12 h-12 rounded-full flex items-center justify-center hover:bg-white/30 transition-colors hover-scale stagger-item shadow-lg">
                                <i class="fab fa-instagram text-lg"></i>
                            </a>
                            @endif
                            @if(isset($settings) && $settings->facebook_url)
                            <a href="{{ $settings->facebook_url }}"
                                class="bg-white/20 w-12 h-12 rounded-full flex items-center justify-center hover:bg-white/30 transition-colors hover-scale stagger-item shadow-lg">
                                <i class="fab fa-facebook-f text-lg"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize scroll animations
            initScrollAnimations();

            // Initialize staggered animations
            initStaggeredAnimations();

            // Add floating animation to elements
            addFloatingAnimation();
        });

        const form = document.getElementById('contactForm');
        const submitBtn = document.getElementById('submit-btn');
        const statusContainer = document.getElementById('status-container');
        const successMessage = document.getElementById('success-message');
        const errorMessage = document.getElementById('error-message');
        const successText = document.getElementById('success-text');
        const errorText = document.getElementById('error-text');

        // Clear error messages when input changes
        const inputs = form.querySelectorAll('input, textarea');
        inputs.forEach(input => {
            input.addEventListener('input', () => {
                const errorElement = document.getElementById(`${input.id}-error`);
                if (errorElement) {
                    errorElement.textContent = '';
                    errorElement.classList.add('hidden');
                }
            });
        });

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            // Reset previous error messages
            document.querySelectorAll('.error-message').forEach(el => {
                el.textContent = '';
                el.classList.add('hidden');
            });

            // Hide status messages
            statusContainer.classList.add('hidden');
            successMessage.classList.add('hidden');
            errorMessage.classList.add('hidden');

            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML =
                '<span>Sending...</span><div class="inline-block animate-spin rounded-full h-4 w-4 border-t-2 border-white"></div>';

            const fd = new FormData(form);

            try {
                const res = await fetch('{{ route('ajax.contact') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: fd
                });

                const data = await res.json();

                statusContainer.classList.remove('hidden');

                if (res.ok) {
                    // Success
                    successMessage.classList.remove('hidden');
                    successText.textContent = data.msg || 'Your message has been sent successfully!';
                    form.reset();
                } else {
                    // Server validation errors
                    errorMessage.classList.remove('hidden');

                    if (data.errors) {
                        // Display validation errors under each field
                        Object.keys(data.errors).forEach(field => {
                            const errorElement = document.getElementById(`${field}-error`);
                            if (errorElement) {
                                errorElement.textContent = data.errors[field][0];
                                errorElement.classList.remove('hidden');
                            }
                        });
                        errorText.textContent = 'Please correct the errors above.';
                    } else {
                        errorText.textContent = data.message ||
                            'Failed to send your message. Please try again.';
                    }
                }
            } catch (error) {
                // Network or other errors
                statusContainer.classList.remove('hidden');
                errorMessage.classList.remove('hidden');
                errorText.textContent = 'An unexpected error occurred. Please try again later.';
            } finally {
                // Reset button state
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<span>Send Message</span><i class="fas fa-paper-plane"></i>';
            }
        });
    </script>
@endsection

