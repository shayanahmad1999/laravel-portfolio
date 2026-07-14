@extends('admin.layouts.app')

@section('title', 'Contact Messages')

@section('content')
<div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sender</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Message</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($messages as $message)
                <tr class="{{ $message->read_at ? '' : 'bg-indigo-50/40' }}">
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">{{ $message->name }}</div>
                        <div class="text-sm text-gray-500">{{ $message->email }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($message->message, 100) }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $message->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.messages.show', $message) }}" class="text-indigo-600 hover:text-indigo-900 mr-3"><i class="fas fa-eye"></i></a>
                        <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" class="inline" onsubmit="return confirm('Delete this message?');">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-6 py-8 text-center text-gray-500">No contact messages yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($messages->hasPages()) <div class="px-6 py-4 border-t">{{ $messages->links() }}</div> @endif
</div>
@endsection

