@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label for="client_name" class="block text-sm font-medium text-gray-700 mb-1">Client Name</label>
        <input type="text" name="client_name" id="client_name" value="{{ old('client_name', $testimonial->client_name) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-200" required>
        @error('client_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
        <select name="rating" id="rating" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-200" required>
            @for ($i = 5; $i >= 1; $i--)
                <option value="{{ $i }}" {{ (int) old('rating', $testimonial->rating ?: 5) === $i ? 'selected' : '' }}>{{ $i }} star{{ $i > 1 ? 's' : '' }}</option>
            @endfor
        </select>
        @error('rating') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="client_role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
        <input type="text" name="client_role" id="client_role" value="{{ old('client_role', $testimonial->client_role) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-200">
    </div>

    <div>
        <label for="client_company" class="block text-sm font-medium text-gray-700 mb-1">Company</label>
        <input type="text" name="client_company" id="client_company" value="{{ old('client_company', $testimonial->client_company) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-200">
    </div>

    <div>
        <label for="avatar" class="block text-sm font-medium text-gray-700 mb-1">Avatar</label>
        @if ($testimonial->avatar)
            <img src="{{ asset('storage/' . $testimonial->avatar) }}" alt="{{ $testimonial->client_name }}" class="mb-2 h-16 w-16 rounded-full object-cover">
            <label class="mb-2 flex items-center gap-2 text-sm text-red-600">
                <input type="checkbox" name="remove_avatar" value="1" class="rounded border-gray-300 text-red-600"> Remove avatar
            </label>
        @endif
        <input type="file" name="avatar" id="avatar" accept="image/*" class="w-full border border-gray-300 rounded-md p-2">
        @error('avatar') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
        <input type="number" min="0" name="sort_order" id="sort_order" value="{{ old('sort_order', $testimonial->sort_order ?? 0) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-200">
        <label class="mt-3 flex items-center gap-2 text-sm text-gray-700">
            <input type="checkbox" name="is_visible" value="1" class="rounded border-gray-300 text-indigo-600" {{ old('is_visible', $testimonial->exists ? $testimonial->is_visible : true) ? 'checked' : '' }}>
            Show on public site
        </label>
    </div>

    <div class="md:col-span-2">
        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
        <textarea name="message" id="message" rows="5" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-200" required>{{ old('message', $testimonial->message) }}</textarea>
        @error('message') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-6 flex justify-end">
    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg">
        <i class="fas fa-save mr-2"></i> Save Testimonial
    </button>
</div>
