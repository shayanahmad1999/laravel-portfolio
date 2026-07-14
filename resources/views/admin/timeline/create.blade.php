@extends('admin.layouts.app')

@section('title', 'Add Timeline Entry')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.timeline.index') }}" class="text-indigo-600 hover:text-indigo-900"><i class="fas fa-arrow-left mr-2"></i> Back to Timeline</a>
</div>
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <form action="{{ route('admin.timeline.store') }}" method="POST">
        @include('admin.timeline._form')
    </form>
</div>
@endsection
