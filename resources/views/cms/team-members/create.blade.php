@extends('layouts.cms')

@section('title', 'Create Team Member | PREC CMS')
@section('page_title', 'Create Team Member')
@section('page_subtitle', 'Add a new team member to your staff directory.')

@section('content')
    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 rounded-3xl p-6">
            <h3 class="font-semibold text-red-900 mb-3">Errors:</h3>
            <ul class="space-y-2 text-sm text-red-800">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('cms.team-members.store') }}" enctype="multipart/form-data"
        class="bg-white border border-gray-100 rounded-3xl p-6 space-y-6">
        @csrf

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h3 class="font-heading text-3xl leading-none">New Team Member</h3>
                <p class="text-sm text-brand-black/60 mt-1">Add a new person to your team.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('cms.team-members.index') }}" class="inline-flex items-center px-6 py-3 rounded-full border border-gray-200 font-semibold hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center px-6 py-3 rounded-full bg-primary text-brand-black font-semibold hover:bg-primary/90 transition">
                    <i data-lucide="check" class="w-4 h-4 mr-2"></i> Create Member
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Name -->
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Full Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        placeholder="e.g., John Smith"
                        class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20 @error('name') ring-2 ring-red-500 @enderror">
                    @error('name')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role -->
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Job Title/Role *</label>
                    <input type="text" name="role" value="{{ old('role') }}" required
                        placeholder="e.g., Property Manager"
                        class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20 @error('role') ring-2 ring-red-500 @enderror">
                    @error('role')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bio -->
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Biography</label>
                    <textarea name="bio" rows="4" placeholder="Brief biography or professional description..."
                        class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">{{ old('bio') }}</textarea>
                    <p class="text-xs text-brand-black/50 mt-1">Max 1000 characters</p>
                </div>

                <!-- Photo -->
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Photo</label>
                    <input type="file" name="photo_url" accept="image/*"
                        class="w-full bg-gray-100 rounded-2xl py-3 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20 @error('photo_url') ring-2 ring-red-500 @enderror">
                    @error('photo_url')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-brand-black/50 mt-1">Upload a professional photo.</p>
                </div>

                <!-- Order -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-sm font-semibold tracking-wider">Display Order</label>
                        <input type="number" name="order" value="{{ old('order') }}" min="0"
                            placeholder="0"
                            class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                        <p class="text-xs text-brand-black/50 mt-1">Lower numbers appear first</p>
                    </div>

                    <!-- Visibility -->
                    <div class="space-y-2">
                        <label class="text-sm font-semibold tracking-wider">Visibility</label>
                        <div class="flex items-center gap-4 mt-4">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="visible" value="1" checked
                                    class="rounded border-gray-300 text-brand-black focus:ring-primary">
                                <span class="text-sm">Visible</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="visible" value="0"
                                    class="rounded border-gray-300 text-brand-black focus:ring-primary">
                                <span class="text-sm">Hidden</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Preview -->
            <div class="lg:col-span-1">
                <div class="bg-gray-50 border border-gray-100 rounded-3xl p-6 sticky top-4">
                    <h4 class="font-heading text-lg mb-4">Preview</h4>

                    <!-- Photo Preview -->
                    <div class="mb-4 h-48 rounded-2xl bg-gradient-to-br from-primary/20 to-primary/10 flex items-center justify-center overflow-hidden">
                        <img id="photoPreview" src="" alt="Preview" class="w-full h-full object-cover hidden">
                        <i data-lucide="user" class="w-16 h-16 text-brand-black/40" id="photoPlaceholder"></i>
                    </div>

                    <!-- Info Preview -->
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs uppercase tracking-widest text-brand-black/50 mb-1">Name</p>
                            <p class="font-semibold text-brand-black" id="previewName">
                                John Smith
                            </p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-widest text-brand-black/50 mb-1">Role</p>
                            <p class="text-sm text-primary font-semibold" id="previewRole">
                                Property Manager
                            </p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-widest text-brand-black/50 mb-1">Bio</p>
                            <p class="text-xs text-brand-black/70 line-clamp-2" id="previewBio">
                                Brief biography...
                            </p>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-primary/20 text-brand-black">
                            <i data-lucide="eye" class="w-3.5 h-3.5"></i> Visible
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex gap-3 pt-6 border-t border-gray-100">
            <a href="{{ route('cms.team-members.index') }}" class="inline-flex items-center px-6 py-3 rounded-full border border-gray-200 font-semibold hover:bg-gray-50 transition">
                Cancel
            </a>
            <button type="submit" class="inline-flex items-center px-6 py-3 rounded-full bg-primary text-brand-black font-semibold hover:bg-primary/90 transition ml-auto">
                <i data-lucide="check" class="w-4 h-4 mr-2"></i> Create Member
            </button>
        </div>
    </form>

    <script>
        // Update preview as user types
        document.querySelectorAll('input[name="name"], input[name="role"], textarea[name="bio"], input[name="photo_url"]').forEach(el => {
            el.addEventListener('input', function() {
                if (this.name === 'name') {
                    document.getElementById('previewName').textContent = this.value || 'John Smith';
                } else if (this.name === 'role') {
                    document.getElementById('previewRole').textContent = this.value || 'Property Manager';
                } else if (this.name === 'bio') {
                    document.getElementById('previewBio').textContent = this.value || 'Brief biography...';
                } else if (this.name === 'photo_url') {
                    const preview = document.getElementById('photoPreview');
                    const placeholder = document.getElementById('photoPlaceholder');
                    if (this.value) {
                        preview.src = this.value;
                        preview.onload = () => {
                            preview.classList.remove('hidden');
                            placeholder.classList.add('hidden');
                        };
                        preview.onerror = () => {
                            preview.classList.add('hidden');
                            placeholder.classList.remove('hidden');
                        };
                    } else {
                        preview.classList.add('hidden');
                        placeholder.classList.remove('hidden');
                    }
                }
            });
        });
    </script>
@endsection
