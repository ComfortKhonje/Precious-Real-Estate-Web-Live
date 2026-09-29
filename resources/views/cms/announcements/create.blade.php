@extends('layouts.cms')

@section('title', 'Add Update | PREC CMS')
@section('page_title', 'Add Update')
@section('page_subtitle', 'Write an announcement, news item or blog post.')

@section('content')
    <form method="POST" action="{{ route('cms.announcements.store') }}" enctype="multipart/form-data">
        @csrf
        @include('cms.announcements._form', ['announcement' => null])
    </form>
@endsection

@push('scripts')
    @vite('resources/js/cms-editor.js')
@endpush
