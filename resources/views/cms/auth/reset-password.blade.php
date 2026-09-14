<x-cms.auth-shell title="Choose a New Password" subtitle="Reset your password">
    <form method="POST" action="{{ route('cms.password.update') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="space-y-1.5">
            <label for="email" class="text-xs tracking-widest text-gray-400 uppercase font-bold">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email', $email) }}" required class="w-full bg-gray-100 rounded-xl py-4 px-5 text-brand-black font-semibold focus:ring-2 focus:ring-primary focus:bg-white border-none text-md">
        </div>
        <div class="space-y-1.5">
            <label for="password" class="text-xs tracking-widest text-gray-400 uppercase font-bold">New Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" class="w-full bg-gray-100 rounded-xl py-4 px-5 text-brand-black font-semibold focus:ring-2 focus:ring-primary focus:bg-white border-none text-md">
            <p class="text-xs text-brand-black/50">At least 8 characters.</p>
        </div>
        <div class="space-y-1.5">
            <label for="password_confirmation" class="text-xs tracking-widest text-gray-400 uppercase font-bold">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="w-full bg-gray-100 rounded-xl py-4 px-5 text-brand-black font-semibold focus:ring-2 focus:ring-primary focus:bg-white border-none text-md">
        </div>

        <button type="submit" class="w-full mt-2 px-6 py-4 bg-brand-black text-white rounded-full font-bold uppercase tracking-widest hover:opacity-90 transition">
            Save New Password
        </button>
    </form>
</x-cms.auth-shell>
