@extends('admin.layouts.app')

@section('title', 'Testimonials')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-gray-800">Client Testimonials</h2>
    <a href="{{ route('admin.testimonials.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg">
        <i class="fas fa-plus mr-2"></i> Add Testimonial
    </a>
</div>

<div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rating</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Visible</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($testimonials as $testimonial)
                <tr>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">{{ $testimonial->client_name }}</div>
                        <div class="text-sm text-gray-500">{{ $testimonial->client_role }} {{ $testimonial->client_company ? 'at ' . $testimonial->client_company : '' }}</div>
                    </td>
                    <td class="px-6 py-4 text-yellow-500">{{ str_repeat('★', $testimonial->rating) }}</td>
                    <td class="px-6 py-4">{{ $testimonial->is_visible ? 'Yes' : 'No' }}</td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="text-indigo-600 hover:text-indigo-900 mr-3"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" class="inline" onsubmit="return confirm('Delete this testimonial?');">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-6 py-8 text-center text-gray-500">No testimonials yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($testimonials->hasPages()) <div class="px-6 py-4 border-t">{{ $testimonials->links() }}</div> @endif
</div>
@endsection


