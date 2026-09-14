@extends('layouts.cms')

@section('title', 'Edit Account | PREC CMS')
@section('page_title', 'Edit Staff Account')
@section('page_subtitle', $user->email)

@section('content')
    <form method="POST" action="{{ route('cms.users.update', $user) }}" class="bg-white border border-gray-100 rounded-3xl p-6 space-y-6">
        @csrf
        @method('PUT')

        @include('cms.users._form', ['account' => $user])

        <div class="flex gap-3 pt-6 border-t border-gray-100">
            <a href="{{ route('cms.users.index') }}" class="inline-flex items-center px-6 py-3 rounded-full border border-gray-200 font-semibold hover:bg-gray-50 transition">Cancel</a>
            <button type="submit" class="inline-flex items-center px-6 py-3 rounded-full bg-primary text-brand-black font-semibold hover:bg-primary/90 transition ml-auto">
                <i data-lucide="check" class="w-4 h-4 mr-2"></i> Save Changes
            </button>
        </div>
    </form>
@endsection
