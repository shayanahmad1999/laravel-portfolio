@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
        <input type="text" name="title" id="title" value="{{ old('title', $entry->title) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-200" required>
        @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="organization" class="block text-sm font-medium text-gray-700 mb-1">Organization</label>
        <input type="text" name="organization" id="organization" value="{{ old('organization', $entry->organization) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-200">
    </div>

    <div>
        <label for="entry_type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
        <select name="entry_type" id="entry_type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-200">
            @foreach(['experience' => 'Experience', 'education' => 'Education', 'certificate' => 'Certificate', 'award' => 'Award'] as $value => $label)
                <option value="{{ $value }}" {{ old('entry_type', $entry->entry_type ?: 'experience') === $value ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
        <input type="number" min="0" name="sort_order" id="sort_order" value="{{ old('sort_order', $entry->sort_order ?? 0) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-200">
    </div>

    <div>
        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
        <input type="date" name="start_date" id="start_date" value="{{ old('start_date', optional($entry->start_date)->format('Y-m-d')) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-200">
    </div>

    <div>
        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
        <input type="date" name="end_date" id="end_date" value="{{ old('end_date', optional($entry->end_date)->format('Y-m-d')) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-200">
        <label class="mt-3 flex items-center gap-2 text-sm text-gray-700">
            <input type="checkbox" name="is_current" value="1" class="rounded border-gray-300 text-indigo-600" {{ old('is_current', $entry->is_current) ? 'checked' : '' }}>
            Current
        </label>
    </div>

    <div class="md:col-span-2">
        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
        <textarea name="description" id="description" rows="5" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-200">{{ old('description', $entry->description) }}</textarea>
    </div>

    <div class="md:col-span-2">
        <label class="flex items-center gap-2 text-sm text-gray-700">
            <input type="checkbox" name="is_visible" value="1" class="rounded border-gray-300 text-indigo-600" {{ old('is_visible', $entry->exists ? $entry->is_visible : true) ? 'checked' : '' }}>
            Show on public site
        </label>
    </div>
</div>

<div class="mt-6 flex justify-end">
    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg">
        <i class="fas fa-save mr-2"></i> Save Timeline Entry
    </button>
</div>
