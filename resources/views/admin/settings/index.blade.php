@extends('admin.layouts.app')

@section('title', 'Site Settings')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="space-y-8">
            <!-- General Settings -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">General Settings</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="site_title" class="block text-sm font-medium text-gray-700 mb-1">Site Title</label>
                        <input type="text" name="site_title" id="site_title" value="{{ old('site_title', $settings->site_title ?? 'My Portfolio') }}" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    </div>
                    
                    <div>
                        <label for="site_description" class="block text-sm font-medium text-gray-700 mb-1">Site Description</label>
                        <input type="text" name="site_description" id="site_description" value="{{ old('site_description', $settings->site_description ?? '') }}" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                </div>
            </div>
            
            <!-- Color Settings -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Color Settings</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <div>
                        <label for="primary_color" class="block text-sm font-medium text-gray-700 mb-1">Primary Color</label>
                        <div class="flex">
                            <input type="color" name="primary_color_picker" id="primary_color_picker" 
                                value="{{ old('primary_color', $settings->primary_color ?? '#4F46E5') }}" 
                                class="h-10 w-10 rounded-l-md border-gray-300 shadow-sm">
                            <input type="text" name="primary_color" id="primary_color" 
                                value="{{ old('primary_color', $settings->primary_color ?? '#4F46E5') }}" 
                                class="flex-1 rounded-r-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                    </div>
                    
                    <div>
                        <label for="secondary_color" class="block text-sm font-medium text-gray-700 mb-1">Secondary Color</label>
                        <div class="flex">
                            <input type="color" name="secondary_color_picker" id="secondary_color_picker" 
                                value="{{ old('secondary_color', $settings->secondary_color ?? '#818CF8') }}" 
                                class="h-10 w-10 rounded-l-md border-gray-300 shadow-sm">
                            <input type="text" name="secondary_color" id="secondary_color" 
                                value="{{ old('secondary_color', $settings->secondary_color ?? '#818CF8') }}" 
                                class="flex-1 rounded-r-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                    </div>
                    
                    <div>
                        <label for="accent_color" class="block text-sm font-medium text-gray-700 mb-1">Accent Color</label>
                        <div class="flex">
                            <input type="color" name="accent_color_picker" id="accent_color_picker" 
                                value="{{ old('accent_color', $settings->accent_color ?? '#F59E0B') }}" 
                                class="h-10 w-10 rounded-l-md border-gray-300 shadow-sm">
                            <input type="text" name="accent_color" id="accent_color" 
                                value="{{ old('accent_color', $settings->accent_color ?? '#F59E0B') }}" 
                                class="flex-1 rounded-r-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                    </div>
                    
                    <div>
                        <label for="button_color" class="block text-sm font-medium text-gray-700 mb-1">Button Color</label>
                        <div class="flex">
                            <input type="color" name="button_color_picker" id="button_color_picker" 
                                value="{{ old('button_color', $settings->button_color ?? '#4F46E5') }}" 
                                class="h-10 w-10 rounded-l-md border-gray-300 shadow-sm">
                            <input type="text" name="button_color" id="button_color" 
                                value="{{ old('button_color', $settings->button_color ?? '#4F46E5') }}" 
                                class="flex-1 rounded-r-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                    </div>
                    
                    <div>
                        <label for="button_hover_color" class="block text-sm font-medium text-gray-700 mb-1">Button Hover Color</label>
                        <div class="flex">
                            <input type="color" name="button_hover_color_picker" id="button_hover_color_picker" 
                                value="{{ old('button_hover_color', $settings->button_hover_color ?? '#4338CA') }}" 
                                class="h-10 w-10 rounded-l-md border-gray-300 shadow-sm">
                            <input type="text" name="button_hover_color" id="button_hover_color" 
                                value="{{ old('button_hover_color', $settings->button_hover_color ?? '#4338CA') }}" 
                                class="flex-1 rounded-r-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                    </div>
                    
                    <div>
                        <label for="text_color" class="block text-sm font-medium text-gray-700 mb-1">Text Color</label>
                        <div class="flex">
                            <input type="color" name="text_color_picker" id="text_color_picker" 
                                value="{{ old('text_color', $settings->text_color ?? '#111827') }}" 
                                class="h-10 w-10 rounded-l-md border-gray-300 shadow-sm">
                            <input type="text" name="text_color" id="text_color" 
                                value="{{ old('text_color', $settings->text_color ?? '#111827') }}" 
                                class="flex-1 rounded-r-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                    </div>
                    
                    <div>
                        <label for="navbar_color" class="block text-sm font-medium text-gray-700 mb-1">Navbar Color</label>
                        <div class="flex">
                            <input type="color" name="navbar_color_picker" id="navbar_color_picker" 
                                value="{{ old('navbar_color', $settings->navbar_color ?? '#FFFFFF') }}" 
                                class="h-10 w-10 rounded-l-md border-gray-300 shadow-sm">
                            <input type="text" name="navbar_color" id="navbar_color" 
                                value="{{ old('navbar_color', $settings->navbar_color ?? '#FFFFFF') }}" 
                                class="flex-1 rounded-r-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                    </div>
                    
                    <div>
                        <label for="navbar_text_color" class="block text-sm font-medium text-gray-700 mb-1">Navbar Text Color</label>
                        <div class="flex">
                            <input type="color" name="navbar_text_color_picker" id="navbar_text_color_picker" 
                                value="{{ old('navbar_text_color', $settings->navbar_text_color ?? '#111827') }}" 
                                class="h-10 w-10 rounded-l-md border-gray-300 shadow-sm">
                            <input type="text" name="navbar_text_color" id="navbar_text_color" 
                                value="{{ old('navbar_text_color', $settings->navbar_text_color ?? '#111827') }}" 
                                class="flex-1 rounded-r-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                    </div>
                    
                    <div>
                        <label for="footer_color" class="block text-sm font-medium text-gray-700 mb-1">Footer Color</label>
                        <div class="flex">
                            <input type="color" name="footer_color_picker" id="footer_color_picker" 
                                value="{{ old('footer_color', $settings->footer_color ?? '#1F2937') }}" 
                                class="h-10 w-10 rounded-l-md border-gray-300 shadow-sm">
                            <input type="text" name="footer_color" id="footer_color" 
                                value="{{ old('footer_color', $settings->footer_color ?? '#1F2937') }}" 
                                class="flex-1 rounded-r-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                    </div>
                    
                    <div>
                        <label for="footer_text_color" class="block text-sm font-medium text-gray-700 mb-1">Footer Text Color</label>
                        <div class="flex">
                            <input type="color" name="footer_text_color_picker" id="footer_text_color_picker" 
                                value="{{ old('footer_text_color', $settings->footer_text_color ?? '#F9FAFB') }}" 
                                class="h-10 w-10 rounded-l-md border-gray-300 shadow-sm">
                            <input type="text" name="footer_text_color" id="footer_text_color" 
                                value="{{ old('footer_text_color', $settings->footer_text_color ?? '#F9FAFB') }}" 
                                class="flex-1 rounded-r-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Contact Information -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Contact Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" name="contact_email" id="contact_email" value="{{ old('contact_email', $settings->contact_email ?? '') }}" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                    
                    <div>
                        <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input type="text" name="contact_phone" id="contact_phone" value="{{ old('contact_phone', $settings->contact_phone ?? '') }}" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="contact_address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                        <input type="text" name="contact_address" id="contact_address" value="{{ old('contact_address', $settings->contact_address ?? '') }}" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                </div>
            </div>
            
            <!-- Social Media Links -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Social Media Links</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="github_url" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="fab fa-github mr-1"></i> GitHub URL
                        </label>
                        <input type="url" name="github_url" id="github_url" value="{{ old('github_url', $settings->github_url ?? '') }}" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                    
                    <div>
                        <label for="linkedin_url" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="fab fa-linkedin mr-1"></i> LinkedIn URL
                        </label>
                        <input type="url" name="linkedin_url" id="linkedin_url" value="{{ old('linkedin_url', $settings->linkedin_url ?? '') }}" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                    
                    <div>
                        <label for="twitter_url" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="fab fa-twitter mr-1"></i> Twitter URL
                        </label>
                        <input type="url" name="twitter_url" id="twitter_url" value="{{ old('twitter_url', $settings->twitter_url ?? '') }}" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                    
                    <div>
                        <label for="facebook_url" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="fab fa-facebook mr-1"></i> Facebook URL
                        </label>
                        <input type="url" name="facebook_url" id="facebook_url" value="{{ old('facebook_url', $settings->facebook_url ?? '') }}" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                    
                    <div>
                        <label for="instagram_url" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="fab fa-instagram mr-1"></i> Instagram URL
                        </label>
                        <input type="url" name="instagram_url" id="instagram_url" value="{{ old('instagram_url', $settings->instagram_url ?? '') }}" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-8 flex justify-end">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Save Settings
            </button>
        </div>
    </form>
</div>

<script>
    // Sync color picker with text input
    document.addEventListener('DOMContentLoaded', function() {
        const colorPickers = [
            'primary_color', 'secondary_color', 'accent_color', 'button_color', 
            'button_hover_color', 'text_color', 'navbar_color', 'navbar_text_color',
            'footer_color', 'footer_text_color'
        ];
        
        colorPickers.forEach(function(color) {
            const picker = document.getElementById(color + '_picker');
            const input = document.getElementById(color);
            
            picker.addEventListener('input', function() {
                input.value = picker.value;
            });
            
            input.addEventListener('input', function() {
                picker.value = input.value;
            });
        });
    });
</script>
@endsection