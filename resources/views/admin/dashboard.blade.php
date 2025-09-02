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
                        @if($project->image)
                            <img src="{{ Storage::url($project->image) }}" alt="{{ $project->title }}" class="w-12 h-12 object-cover rounded mr-4">
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
@endsection