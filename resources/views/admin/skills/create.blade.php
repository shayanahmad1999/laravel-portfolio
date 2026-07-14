@extends('admin.layouts.app')

@section('title', 'Add New Skill')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.skills.index') }}" class="text-indigo-600 hover:text-indigo-900 flex items-center">
        <i class="fas fa-arrow-left mr-2"></i> Back to Skills
    </a>
</div>

<div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-6">Add New Skill</h2>
        
        <form action="{{ route('admin.skills.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Skill Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="logo" class="block text-sm font-medium text-gray-700 mb-1">Skill Logo</label>
                <input type="file" name="logo" id="logo" class="w-full border border-gray-300 rounded-md p-2" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                <p class="mt-1 text-sm text-gray-500">Optional. Upload JPG, PNG, GIF, or WebP up to 2MB.</p>
                @error('logo')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="level" class="block text-sm font-medium text-gray-700 mb-1">Skill Level (1-100)</label>
                <div class="flex items-center space-x-4">
                    <input type="range" name="level" id="level" min="1" max="100" value="{{ old('level', 50) }}" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer" oninput="updateLevelValue(this.value)">
                    <span id="levelValue" class="text-sm font-medium text-gray-700 w-12 text-center">50%</span>
                </div>
                @error('level')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg flex items-center">
                    <i class="fas fa-save mr-2"></i> Save Skill
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function updateLevelValue(val) {
        document.getElementById('levelValue').innerText = val + '%';
    }
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        const initialValue = document.getElementById('level').value;
        updateLevelValue(initialValue);
    });
</script>
@endsection

