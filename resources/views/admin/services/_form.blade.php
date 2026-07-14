@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Service Title</label>
        <input type="text" name="title" id="title" value="{{ old('title', $service->title) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-200" required>
        @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="icon" class="block text-sm font-medium text-gray-700 mb-1">Font Awesome Icon Class</label>
        <input type="text" name="icon" id="icon" value="{{ old('icon', $service->icon ?: 'fas fa-laptop-code') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-200" placeholder="fas fa-laptop-code" required>
        <p class="mt-1 text-sm text-gray-500">Example: fas fa-mobile-alt, fas fa-server, fas fa-paint-brush</p>
        @error('icon') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="accent_color" class="block text-sm font-medium text-gray-700 mb-1">Accent Color</label>
        <select name="accent_color" id="accent_color" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-200">
            @foreach(['indigo' => 'Indigo', 'purple' => 'Purple', 'blue' => 'Blue', 'emerald' => 'Emerald', 'rose' => 'Rose', 'amber' => 'Amber'] as $value => $label)
                <option value="{{ $value }}" {{ old('accent_color', $service->accent_color ?: 'indigo') === $value ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        @error('accent_color') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
        <input type="number" min="0" name="sort_order" id="sort_order" value="{{ old('sort_order', $service->sort_order ?? 0) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-200">
        <label class="mt-3 flex items-center gap-2 text-sm text-gray-700">
            <input type="checkbox" name="is_visible" value="1" class="rounded border-gray-300 text-indigo-600" {{ old('is_visible', $service->exists ? $service->is_visible : true) ? 'checked' : '' }}>
            Show on public site
        </label>
    </div>

    <div class="md:col-span-2">
        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
        <textarea name="description" id="description" rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-200" required>{{ old('description', $service->description) }}</textarea>
        @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="md:col-span-2">
        <label for="features" class="block text-sm font-medium text-gray-700 mb-1">Features</label>
        <textarea name="features" id="features" rows="5" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-200" placeholder="One feature per line">{{ old('features', is_array($service->features) ? implode("\n", $service->features) : '') }}</textarea>
        <p class="mt-1 text-sm text-gray-500">Write one feature per line. These appear as checkmark bullets on the public page.</p>
        @error('features') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-6 flex justify-end">
    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg">
        <i class="fas fa-save mr-2"></i> Save Service
    </button>
</div>
