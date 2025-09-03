@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Projects Stats -->
    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-indigo-100 text-indigo-600 mr-4">
                <i class="fas fa-project-diagram text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Total Projects</p>
                <p class="text-2xl font-semibold text-gray-800">{{ $stats['projects'] }}</p>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('admin.projects.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                View all projects <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>

    <!-- Skills Stats -->
    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                <i class="fas fa-code text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Total Skills</p>
                <p class="text-2xl font-semibold text-gray-800">{{ $stats['skills'] }}</p>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('admin.skills.index') }}" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                View all skills <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>

    <!-- Categories Stats -->
    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                <i class="fas fa-tags text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Total Categories</p>
                <p class="text-2xl font-semibold text-gray-800">{{ $stats['categories'] }}</p>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('admin.categories.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                View all categories <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Recent Projects -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="font-medium text-gray-700">Recent Projects</h3>
        </div>
        <div class="divide-y divide-gray-200">
            @forelse($recentProjects as $project)
                <div class="px-6 py-4">
                    <div class="flex items-center">
                        @if($project->thumbnail)
                            <img src="{{ Storage::url($project->thumbnail) }}" alt="{{ $project->title }}" class="w-12 h-12 object-cover rounded mr-4">
                        @else
                            <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center mr-4">
                                <i class="fas fa-image text-gray-400"></i>
                            </div>
                        @endif
                        <div>
                            <h4 class="font-medium text-gray-800">{{ $project->title }}</h4>
                            <p class="text-sm text-gray-500">{{ $project->category->name ?? 'No Category' }}</p>
                        </div>
                        <a href="{{ route('admin.projects.edit', $project) }}" class="ml-auto text-gray-400 hover:text-indigo-600">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="px-6 py-4 text-gray-500 text-center">
                    No projects found.
                </div>
            @endforelse
        </div>
        @if($recentProjects->isNotEmpty())
            <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
                <a href="{{ route('admin.projects.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                    View all projects
                </a>
            </div>
        @endif
    </div>

    <!-- Recent Skills -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="font-medium text-gray-700">Recent Skills</h3>
        </div>
        <div class="divide-y divide-gray-200">
            @forelse($recentSkills as $skill)
                <div class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="mr-4 p-2 bg-purple-100 text-purple-600 rounded">
                            <i class="fas fa-code"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-800">{{ $skill->name }}</h4>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                                <div class="bg-purple-600 h-2.5 rounded-full" style="width: {{ $skill->level }}%"></div>
                            </div>
                        </div>
                        <span class="ml-4 text-sm font-medium text-gray-600">{{ $skill->level }}%</span>
                        <a href="{{ route('admin.skills.edit', $skill) }}" class="ml-4 text-gray-400 hover:text-purple-600">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="px-6 py-4 text-gray-500 text-center">
                    No skills found.
                </div>
            @endforelse
        </div>
        @if($recentSkills->isNotEmpty())
            <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
                <a href="{{ route('admin.skills.index') }}" class="text-sm text-purple-600 hover:text-purple-800 font-medium">
                    View all skills
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Portfolio Sharing Section -->
<div class="mt-8 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <h3 class="font-medium text-gray-700 mb-4">Portfolio Sharing</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" id="portfolio-public" class="mr-2 rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <span class="text-sm font-medium text-gray-700">Make portfolio public</span>
                </label>
                <p class="text-xs text-gray-500 mt-1">Allow others to view your portfolio without logging in</p>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Portfolio URL</label>
                <div class="flex">
                    <input type="text" id="share-url" class="flex-1 rounded-l-lg border-gray-300 border-r-0 bg-gray-50" readonly placeholder="Generate a link first...">
                    <button id="copy-url" class="px-4 py-2 bg-indigo-600 text-white rounded-r-lg border border-indigo-600 hover:bg-indigo-700 disabled:opacity-50" disabled>
                        <i class="fas fa-copy"></i>
                    </button>
                </div>
            </div>
            
            <button id="generate-link" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                <i class="fas fa-link mr-2"></i>Generate Share Link
            </button>
        </div>
        
        <div class="bg-gray-50 rounded-lg p-4">
            <h4 class="font-medium text-gray-700 mb-2">Sharing Instructions</h4>
            <ul class="text-sm text-gray-600 space-y-1">
                <li>• Enable "Make portfolio public" to allow public access</li>
                <li>• Generate a share link to get a custom URL</li>
                <li>• Share this URL with potential clients or employers</li>
                <li>• You can disable public access anytime</li>
            </ul>
        </div>
    </div>
</div>

<div class="mt-8 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <h3 class="font-medium text-gray-700 mb-4">Quick Actions</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('admin.projects.create') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
            <div class="p-2 bg-indigo-100 text-indigo-600 rounded mr-3">
                <i class="fas fa-plus"></i>
            </div>
            <span class="font-medium text-gray-700">Add New Project</span>
        </a>
        
        <a href="{{ route('admin.skills.create') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
            <div class="p-2 bg-purple-100 text-purple-600 rounded mr-3">
                <i class="fas fa-plus"></i>
            </div>
            <span class="font-medium text-gray-700">Add New Skill</span>
        </a>
        
        <a href="{{ route('admin.categories.create') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
            <div class="p-2 bg-blue-100 text-blue-600 rounded mr-3">
                <i class="fas fa-plus"></i>
            </div>
            <span class="font-medium text-gray-700">Add New Category</span>
        </a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const publicCheckbox = document.getElementById('portfolio-public');
    const shareUrlInput = document.getElementById('share-url');
    const copyButton = document.getElementById('copy-url');
    const generateButton = document.getElementById('generate-link');
    
    // Load current sharing info
    loadSharingInfo();
    
    async function loadSharingInfo() {
        try {
            const response = await fetch('/portfolio/sharing-info');
            const data = await response.json();
            
            publicCheckbox.checked = data.is_public;
            if (data.share_url) {
                shareUrlInput.value = data.share_url;
                copyButton.disabled = false;
            }
        } catch (error) {
            console.error('Error loading sharing info:', error);
        }
    }
    
    // Handle public checkbox change
    publicCheckbox.addEventListener('change', async function() {
        try {
            await fetch('/portfolio/visibility', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    is_portfolio_public: this.checked
                })
            });
        } catch (error) {
            console.error('Error updating visibility:', error);
            // Revert checkbox on error
            this.checked = !this.checked;
        }
    });
    
    // Handle generate link button
    generateButton.addEventListener('click', async function() {
        try {
            const response = await fetch('/portfolio/generate-link', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            
            const data = await response.json();
            shareUrlInput.value = data.share_url;
            copyButton.disabled = false;
        } catch (error) {
            console.error('Error generating link:', error);
        }
    });
    
    // Handle copy to clipboard
    copyButton.addEventListener('click', async function() {
        try {
            await navigator.clipboard.writeText(shareUrlInput.value);
            
            // Show success feedback
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-check"></i>';
            this.classList.add('bg-green-600');
            this.classList.remove('bg-indigo-600');
            
            setTimeout(() => {
                this.innerHTML = originalText;
                this.classList.remove('bg-green-600');
                this.classList.add('bg-indigo-600');
            }, 1500);
        } catch (error) {
            console.error('Failed to copy URL:', error);
        }
    });
});
</script>

@endsection
