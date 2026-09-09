{{--
    Single global toast system for the whole site (public + CMS) — bottom
    right, stacked, auto-dismissing. Added 2026-09-08 to replace a pile of
    inconsistent, duplicated success/error UI: CMS pages each had their own
    session('status') banner at the top of the page (different markup per
    view), public forms each had their own inline x-show error/success box
    baked into the form itself. One Alpine store now, triggered three ways:

    1. From any Alpine component's own JS: `window.showToast('success', 'Saved.')`
    2. From a plain fetch()/anywhere: `window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'success', message: 'Saved.' } }))`
    3. Automatically on page load, if the server flashed a `session('status')`
       or `session('error')` — see the data-* attributes below. Controllers
       don't need to change; they already flash 'status' on every redirect.

    Include this partial once, near the end of <body>, in both
    layouts/app.blade.php and layouts/cms.blade.php.
--}}
<div
    x-data="{
        toasts: [],
        nextId: 1,
        add(type, message) {
            if (!message) return;
            const id = this.nextId++;
            this.toasts.push({ id, type, message });
            setTimeout(() => this.remove(id), 5000);
        },
        remove(id) {
            this.toasts = this.toasts.filter(t => t.id !== id);
        },
    }"
    x-init="
        window.showToast = (type, message) => add(type, message);
        window.addEventListener('toast', (e) => add(e.detail.type, e.detail.message));
        @if (session('status'))
            add('success', @js(session('status')));
        @endif
        @if (session('error'))
            add('error', @js(session('error')));
        @endif
    "
    class="fixed bottom-4 right-4 z-[300] flex flex-col gap-2 w-[calc(100%-2rem)] max-w-sm pointer-events-none"
>
    <template x-for="toast in toasts" :key="toast.id">
        <div
            x-show="true"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-2 translate-x-2"
            x-transition:enter-end="opacity-100 translate-y-0 translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="pointer-events-auto flex items-start gap-3 bg-brand-black text-white rounded-2xl shadow-2xl p-4 pr-3 border-l-4"
            :class="toast.type === 'error' ? 'border-red-500' : 'border-primary'"
        >
            <div class="w-6 h-6 rounded-full flex items-center justify-center shrink-0 mt-0.5"
                :class="toast.type === 'error' ? 'bg-red-500/20 text-red-400' : 'bg-primary/20 text-primary'">
                <svg x-show="toast.type !== 'error'" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                <svg x-show="toast.type === 'error'" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
            </div>
            <p class="text-sm font-medium leading-snug flex-1" x-text="toast.message"></p>
            <button type="button" @click="remove(toast.id)" class="text-white/40 hover:text-white transition shrink-0 p-1 -m-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </template>
</div>
