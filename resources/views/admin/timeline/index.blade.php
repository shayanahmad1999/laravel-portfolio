@extends('admin.layouts.app')

@section('title', 'Timeline')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-gray-800">Experience, Education & Certificates</h2>
    <a href="{{ route('admin.timeline.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg">
        <i class="fas fa-plus mr-2"></i> Add Entry
    </a>
</div>

<div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Period</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Visible</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($entries as $entry)
                <tr>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">{{ $entry->title }}</div>
                        <div class="text-sm text-gray-500">{{ $entry->organization }}</div>
                    </td>
                    <td class="px-6 py-4 capitalize">{{ $entry->entry_type }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        {{ optional($entry->start_date)->format('M Y') ?: 'Anytime' }} -
                        {{ $entry->is_current ? 'Present' : (optional($entry->end_date)->format('M Y') ?: 'Now') }}
                    </td>
                    <td class="px-6 py-4">{{ $entry->is_visible ? 'Yes' : 'No' }}</td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.timeline.edit', $entry) }}" class="text-indigo-600 hover:text-indigo-900 mr-3"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.timeline.destroy', $entry) }}" method="POST" class="inline" onsubmit="return confirm('Delete this timeline entry?');">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">No timeline entries yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($entries->hasPages()) <div class="px-6 py-4 border-t">{{ $entries->links() }}</div> @endif
</div>
@endsection
