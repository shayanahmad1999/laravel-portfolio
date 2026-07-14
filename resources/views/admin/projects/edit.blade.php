@extends('admin.layouts.app')

@section('title', 'Edit Project')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.projects.index') }}" class="text-indigo-600 hover:text-indigo-900 flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Back to Projects
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-6">Edit Project: {{ $project->title }}</h2>

            <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-1">
                        <div class="mb-6">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Project Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $project->title) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <select name="category_id" id="category_id"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $project->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="tags" class="block text-sm font-medium text-gray-700 mb-1">Tags (comma
                                separated)</label>
                            <input type="text" name="tags" id="tags"
                                value="{{ old('tags', is_array($project->tags) ? implode(', ', $project->tags) : $project->tags) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                placeholder="e.g. Laravel, Vue, API">
                            @error('tags')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Project Image</label>
                            @if ($project->thumbnail)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->title }}"
                                        class="h-32 w-auto rounded-md object-cover">
                                </div>
                            @endif
                            <input type="file" name="image" id="image"
                                class="w-full border border-gray-300 rounded-md p-2" accept="image/*">
                            <p class="mt-1 text-sm text-gray-500">Leave empty to keep the current image</p>
                            @error('image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="project_files" class="block text-sm font-medium text-gray-700 mb-1">Project Files</label>

                            @if (!empty($project->project_files))
                                <div class="mb-3 space-y-2">
                                    @foreach ($project->project_files as $index => $file)
                                        @php
                                            $isImage = isset($file['mime']) && str_starts_with($file['mime'], 'image/');
                                        @endphp
                                        <label class="flex items-center gap-3 rounded-md border border-gray-200 p-3">
                                            @if ($isImage)
                                                <img src="{{ asset('storage/' . $file['path']) }}" alt="{{ $file['name'] ?? 'Project file' }}"
                                                    class="h-12 w-12 rounded object-cover">
                                            @else
                                                <span class="flex h-12 w-12 items-center justify-center rounded bg-gray-100 text-gray-500">
                                                    <i class="fas fa-file"></i>
                                                </span>
                                            @endif
                                            <span class="min-w-0 flex-1 truncate text-sm text-gray-700">{{ $file['name'] ?? basename($file['path']) }}</span>
                                            <input type="checkbox" name="remove_project_files[]" value="{{ $index }}"
                                                class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                            <span class="text-sm text-red-600">Remove</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif

                            <input type="file" name="project_files[]" id="project_files" multiple
                                class="w-full border border-gray-300 rounded-md p-2"
                                accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.zip">
                            <p class="mt-1 text-sm text-gray-500">New files will be added to the existing project files.</p>
                            @error('project_files')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @error('project_files.*')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="gallery_images" class="block text-sm font-medium text-gray-700 mb-1">Project Gallery Images</label>
                            @if (!empty($project->gallery_images))
                                <div class="mb-3 grid grid-cols-2 gap-3">
                                    @foreach ($project->gallery_images as $index => $image)
                                        <label class="rounded-md border border-gray-200 p-2">
                                            <img src="{{ asset('storage/' . $image['path']) }}" alt="{{ $image['name'] ?? 'Gallery image' }}" class="mb-2 h-24 w-full rounded object-cover">
                                            <span class="flex items-center justify-between gap-2 text-sm text-red-600">
                                                <span>Remove</span>
                                                <input type="checkbox" name="remove_gallery_images[]" value="{{ $index }}" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                            <input type="file" name="gallery_images[]" id="gallery_images" multiple
                                class="w-full border border-gray-300 rounded-md p-2" accept="image/*">
                            <p class="mt-1 text-sm text-gray-500">New screenshots will be added to the existing gallery.</p>
                            @error('gallery_images.*')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="col-span-1">
                        <div class="mb-6 rounded-md border border-indigo-100 bg-indigo-50 p-4">
                            <label class="flex items-start gap-3">
                                <input type="checkbox" name="is_featured" value="1" class="mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" {{ old('is_featured', $project->is_featured) ? 'checked' : '' }}>
                                <span>
                                    <span class="block text-sm font-medium text-gray-800">Feature this project</span>
                                    <span class="block text-sm text-gray-600">Featured projects are highlighted and can be filtered on the public projects page.</span>
                                </span>
                            </label>
                            @error('is_featured')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="body" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea name="body" id="body" rows="4"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>{{ old('body', $project->body) }}</textarea>
                            @error('body')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="live_url" class="block text-sm font-medium text-gray-700 mb-1">Live Demo URL</label>
                            <input type="url" name="live_url" id="live_url"
                                value="{{ old('live_url', $project->live_url) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                placeholder="https://">
                            @error('live_url')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="repo_url" class="block text-sm font-medium text-gray-700 mb-1">GitHub URL</label>
                            <input type="url" name="repo_url" id="repo_url"
                                value="{{ old('repo_url', $project->repo_url) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                placeholder="https://github.com/">
                            @error('repo_url')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-4">
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg flex items-center">
                        <i class="fas fa-save mr-2"></i> Update Project
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

