@extends('layouts.cms')

@section('title', 'Edit Update | PREC CMS')
@section('page_title', 'Edit Update')
@section('page_subtitle', $announcement->title)

@section('content')
    <form method="POST" action="{{ route('cms.announcements.update', $announcement) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('cms.announcements._form')
    </form>
@endsection

@push('scripts')
    @vite('resources/js/cms-editor.js')
@endpush
