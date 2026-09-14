{{-- Shared by create/edit. $account is null on create. --}}
@php $isSelf = $account && $account->is(auth()->user()); @endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    <div class="space-y-2">
        <label for="name" class="text-sm font-semibold tracking-wider">Full Name *</label>
        <input id="name" type="text" name="name" value="{{ old('name', $account?->name) }}" required class="cms-input @error('name') ring-2 ring-red-500 @enderror">
        @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>
    <div class="space-y-2">
        <label for="email" class="text-sm font-semibold tracking-wider">Login Email *</label>
        <input id="email" type="email" name="email" value="{{ old('email', $account?->email) }}" required class="cms-input @error('email') ring-2 ring-red-500 @enderror">
        @error('email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<fieldset class="space-y-3">
    <legend class="text-sm font-semibold tracking-wider mb-2">Role *</legend>
    @if($isSelf)
        <input type="hidden" name="role" value="{{ $account->role }}">
        <p class="text-sm text-brand-black/60">You're {{ $account->roleLabel() }}. Your own role can only be changed by another Super Admin.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            @foreach($roles as $role)
                <label class="flex gap-3 p-4 rounded-2xl bg-gray-50 border border-gray-100 cursor-pointer has-[:checked]:border-primary has-[:checked]:bg-primary/10">
                    <input type="radio" name="role" value="{{ $role }}" class="mt-1 text-brand-black focus:ring-primary"
                        @checked(old('role', $account?->role ?? 'editor') === $role)>
                    <span>
                        <span class="block font-semibold">{{ \App\Models\User::ROLE_LABELS[$role] }}</span>
                        <span class="block text-xs text-brand-black/60 mt-1">{{ \App\Models\User::ROLE_DESCRIPTIONS[$role] }}</span>
                    </span>
                </label>
            @endforeach
        </div>
    @endif
    @error('role') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
</fieldset>

<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    <div class="space-y-2">
        <label for="password" class="text-sm font-semibold tracking-wider">{{ $account ? 'New Password' : 'Password' }}</label>
        <input id="password" type="password" name="password" autocomplete="new-password" class="cms-input @error('password') ring-2 ring-red-500 @enderror">
        @error('password') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        <p class="text-xs text-brand-black/50 mt-1">
            {{ $account ? 'Leave blank to keep the current password.' : 'At least 8 characters. Leave blank to generate a strong one — it is shown once after saving.' }}
        </p>
    </div>
    @unless($isSelf)
        <div class="space-y-2">
            <x-cms.toggle name="must_change_password" :checked="old('must_change_password', true)"
                label="Require a new password at first login"
                description="Recommended whenever you set the password for someone else." />
        </div>
    @endunless
</div>
