@extends('layouts.cms')

@section('title', 'Create Team Member | PREC CMS')
@section('page_title', 'Create Team Member')
@section('page_subtitle', 'Add a new team member to your staff directory.')

@section('content')
    <form method="POST" action="{{ route('cms.team-members.store') }}" enctype="multipart/form-data"
        class="bg-white border border-gray-100 rounded-3xl p-6 space-y-6">
        @csrf

        <div class="mb-6">
            <h3 class="font-heading text-3xl leading-none">New Team Member</h3>
            <p class="text-sm text-brand-black/60 mt-1">Add a new person to your team.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Name -->
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Full Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        placeholder="e.g., John Smith"
                        class="cms-input @error('name') ring-2 ring-red-500 @enderror">
                    @error('name')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role -->
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Job Title/Role *</label>
                    <input type="text" name="role" value="{{ old('role') }}" required
                        placeholder="e.g., Property Manager"
                        class="cms-input @error('role') ring-2 ring-red-500 @enderror">
                    @error('role')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Qualifications & Experience -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-sm font-semibold tracking-wider">Qualifications</label>
                        <input type="text" name="qualifications" value="{{ old('qualifications') }}"
                            placeholder="e.g., MSc Real Estate, MIS(SA)"
                            class="cms-input">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold tracking-wider">Years of Experience</label>
                        <input type="number" name="years_experience" value="{{ old('years_experience') }}" min="0" max="100"
                            placeholder="e.g., 12"
                            class="cms-input">
                    </div>
                </div>

                <!-- Bio -->
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Biography</label>
                    <textarea name="bio" rows="4" placeholder="Brief biography or professional description..."
                        class="cms-input">{{ old('bio') }}</textarea>
                    <p class="text-xs text-brand-black/50 mt-1">Max 1000 characters</p>
                </div>

                <!-- Photo -->
                <div class="space-y-2">
                    <x-cms.image-upload name="photo_url" label="Upload Photo" help="Professional headshot recommended" />
                </div>

                <!-- Order -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-sm font-semibold tracking-wider">Display Order</label>
                        <input type="number" name="order" value="{{ old('order') }}" min="0"
                            placeholder="0"
                            class="cms-input">
                        <p class="text-xs text-brand-black/50 mt-1">Lower numbers appear first</p>
                    </div>

                    <!-- Visibility -->
                    <div class="space-y-2">
                        <x-cms.toggle name="visible" :checked="old('visible', true)"
                            label="Visible" description="Shown on the team page." />
                    </div>
                </div>
            </div>

            <!-- Preview -->
            <div class="lg:col-span-1">
                <div class="bg-gray-50 border border-gray-100 rounded-3xl p-6 sticky top-4">
                    <h4 class="font-heading text-lg mb-4">Preview</h4>

                    {{-- Photo preview lives inline under the Photo field itself now
                         (x-cms.image-upload shows its own thumbnail immediately on
                         selection) — this sidebar mirror is just a static icon. --}}
                    <div class="mb-4 h-48 rounded-2xl bg-gradient-to-br from-primary/20 to-primary/10 flex items-center justify-center overflow-hidden">
                        <i data-lucide="user" class="w-16 h-16 text-brand-black/40"></i>
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
        // Update preview as user types. Photo preview lives inline under the
        // Photo field itself (x-cms.image-upload) — not mirrored here.
        document.querySelectorAll('input[name="name"], input[name="role"], textarea[name="bio"]').forEach(el => {
            el.addEventListener('input', function() {
                if (this.name === 'name') {
                    document.getElementById('previewName').textContent = this.value || 'John Smith';
                } else if (this.name === 'role') {
                    document.getElementById('previewRole').textContent = this.value || 'Property Manager';
                } else if (this.name === 'bio') {
                    document.getElementById('previewBio').textContent = this.value || 'Brief biography...';
                }
            });
        });
    </script>
@endsection
