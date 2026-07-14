@extends('admin.layouts.app')

@section('title', 'Services')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-gray-800">What I Do Services</h2>
    <a href="{{ route('admin.services.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg">
        <i class="fas fa-plus mr-2"></i> Add Service
    </a>
</div>

<div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Service</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Icon</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Features</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Visible</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($services as $service)
                <tr>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">{{ $service->title }}</div>
                        <div class="text-sm text-gray-500">{{ \Illuminate\Support\Str::limit($service->description, 80) }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $serviceColors = [
                                'indigo' => 'bg-indigo-50 text-indigo-600',
                                'purple' => 'bg-purple-50 text-purple-600',
                                'blue' => 'bg-blue-50 text-blue-600',
                                'emerald' => 'bg-emerald-50 text-emerald-600',
                                'rose' => 'bg-rose-50 text-rose-600',
                                'amber' => 'bg-amber-50 text-amber-600',
                            ];
                            $serviceColor = $serviceColors[$service->accent_color] ?? $serviceColors['indigo'];
                        @endphp
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded {{ $serviceColor }}">
                            <i class="{{ $service->icon }}"></i>
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ count($service->features ?? []) }}</td>
                    <td class="px-6 py-4">{{ $service->is_visible ? 'Yes' : 'No' }}</td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.services.edit', $service) }}" class="text-indigo-600 hover:text-indigo-900 mr-3"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="inline" onsubmit="return confirm('Delete this service?');">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">No services yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($services->hasPages()) <div class="px-6 py-4 border-t">{{ $services->links() }}</div> @endif
</div>
@endsection
