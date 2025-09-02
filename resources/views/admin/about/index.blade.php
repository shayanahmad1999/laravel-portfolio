@extends('admin.layouts.app')

@section('title', 'Manage About Information')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data">
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

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div class="space-y-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $about->title ?? '') }}" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                </div>
                
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                    <textarea name="content" id="content" rows="8" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>{{ old('content', $about->content ?? '') }}</textarea>
                    <p class="text-sm text-gray-500 mt-1">Describe yourself, your skills, and your experience.</p>
                </div>
                
                <div>
                    <label for="resume_link" class="block text-sm font-medium text-gray-700 mb-1">Resume Link</label>
                    <input type="url" name="resume_link" id="resume_link" value="{{ old('resume_link', $about->resume_link ?? '') }}" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                        placeholder="https://example.com/resume.pdf">
                    <p class="text-sm text-gray-500 mt-1">Link to your downloadable resume (optional)</p>
                </div>
            </div>
            
            <!-- Right Column -->
            <div class="space-y-6">
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Profile Image</label>
                    @if(isset($about) && $about->image)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $about->image) }}" alt="Profile Image" class="w-32 h-32 object-cover rounded-lg">
                        </div>
                    @endif
                    <input type="file" name="image" id="image" 
                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    <p class="text-sm text-gray-500 mt-1">Upload a professional profile image (optional)</p>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="years_experience" class="block text-sm font-medium text-gray-700 mb-1">Years Experience</label>
                        <input type="number" name="years_experience" id="years_experience" value="{{ old('years_experience', $about->years_experience ?? 0) }}" min="0" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                    
                    <div>
                        <label for="completed_projects" class="block text-sm font-medium text-gray-700 mb-1">Completed Projects</label>
                        <input type="number" name="completed_projects" id="completed_projects" value="{{ old('completed_projects', $about->completed_projects ?? 0) }}" min="0" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                    
                    <div>
                        <label for="companies_worked" class="block text-sm font-medium text-gray-700 mb-1">Companies Worked</label>
                        <input type="number" name="companies_worked" id="companies_worked" value="{{ old('companies_worked', $about->companies_worked ?? 0) }}" min="0" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-8 flex justify-end">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Save About Information
            </button>
        </div>
    </form>
</div>
@endsection