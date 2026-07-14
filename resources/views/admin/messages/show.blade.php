@extends('admin.layouts.app')

@section('title', 'Contact Message')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.messages.index') }}" class="text-indigo-600 hover:text-indigo-900"><i class="fas fa-arrow-left mr-2"></i> Back to Messages</a>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <div class="mb-6 border-b pb-4">
        <h2 class="text-xl font-semibold text-gray-900">{{ $message->name }}</h2>
        <a href="mailto:{{ $message->email }}" class="text-indigo-600">{{ $message->email }}</a>
        <p class="mt-1 text-sm text-gray-500">{{ $message->created_at->format('M d, Y g:i A') }}</p>
    </div>
    <div class="whitespace-pre-line leading-relaxed text-gray-700">{{ $message->message }}</div>
</div>
@endsection
