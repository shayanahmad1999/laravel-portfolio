@extends('admin.layouts.app')

@section('title', 'Manage Skills')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-gray-800">All Skills</h2>
    <a href="{{ route('admin.skills.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg flex items-center">
        <i class="fas fa-plus mr-2"></i> Add New Skill
    </a>
</div>

<div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Logo</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Level</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($skills as $skill)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($skill->logo)
                                <img src="{{ asset('storage/' . $skill->logo) }}" alt="{{ $skill->name }}" class="h-10 w-10 rounded object-contain bg-gray-50 border border-gray-200">
                            @else
                                <div class="h-10 w-10 rounded bg-gray-100 border border-gray-200 flex items-center justify-center text-gray-400">
                                    <i class="fas fa-code"></i>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $skill->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $skill->level }}%</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $skill->level }}%"></div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('admin.skills.edit', $skill) }}" class="text-indigo-600 hover:text-indigo-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.skills.destroy', $skill) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this skill?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                            No skills found. <a href="{{ route('admin.skills.create') }}" class="text-indigo-600 hover:text-indigo-900">Add your first skill</a>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($skills->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $skills->links() }}
        </div>
    @endif
</div>
@endsection
