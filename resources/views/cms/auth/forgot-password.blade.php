<x-cms.auth-shell title="Forgot Password" subtitle="Reset your password">
    <p class="text-sm text-brand-black/70 mb-5">Enter your CMS login email and we'll send you a link to choose a new password.</p>

    <form method="POST" action="{{ route('cms.password.email') }}" class="space-y-4">
        @csrf
        <div class="space-y-1.5">
            <label for="email" class="text-xs tracking-widest text-gray-400 uppercase font-bold">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full bg-gray-100 rounded-xl py-4 px-5 text-brand-black font-semibold focus:ring-2 focus:ring-primary focus:bg-white border-none text-md">
        </div>

        <button type="submit" class="w-full mt-2 px-6 py-4 bg-brand-black text-white rounded-full font-bold uppercase tracking-widest hover:opacity-90 transition">
            Send Reset Link
        </button>
    </form>

    <a href="{{ route('cms.login') }}" class="mt-6 inline-block text-sm font-semibold text-brand-black hover:underline">&larr; Back to login</a>
</x-cms.auth-shell>
