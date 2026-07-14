@extends('admin.layouts.app')

@section('title', 'Add Service')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.services.index') }}" class="text-indigo-600 hover:text-indigo-900"><i class="fas fa-arrow-left mr-2"></i> Back to Services</a>
</div>
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <form action="{{ route('admin.services.store') }}" method="POST">
        @include('admin.services._form')
    </form>
</div>
@endsection
