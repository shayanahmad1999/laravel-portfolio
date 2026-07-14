@extends('admin.layouts.app')

@section('title', 'Add Testimonial')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.testimonials.index') }}" class="text-indigo-600 hover:text-indigo-900"><i class="fas fa-arrow-left mr-2"></i> Back to Testimonials</a>
</div>
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
        @include('admin.testimonials._form')
    </form>
</div>
@endsection
