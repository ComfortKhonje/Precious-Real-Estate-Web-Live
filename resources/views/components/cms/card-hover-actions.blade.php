@props([
    'editRoute',
    'deleteFormId',
    'deleteMessage' => 'Delete this item?',
])

{{--
    Shared hover overlay (Edit + Delete) for CMS card grids. Delete wires
    into the global confirm modal in layouts/cms.blade.php rather than a
    native confirm() — addslashes() here + Blade's {{ }} escaping is the
    same double-escape team-members' index already relied on: the quote
    survives as an HTML entity, the browser decodes it back to `\'` before
    the JS attribute is parsed, so an apostrophe in a title never breaks
    out of the single-quoted Alpine expression.
--}}
<div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2">
    <a href="{{ $editRoute }}" class="p-2 rounded-full bg-primary text-brand-black hover:bg-primary/90 transition flex items-center justify-center" title="Edit">
        <i data-lucide="pencil" class="w-4 h-4"></i>
    </a>
    <button type="button"
        @click="confirmFormId = '{{ $deleteFormId }}'; confirmMessage = '{{ addslashes($deleteMessage) }}'; confirmModalOpen = true"
        class="p-2 rounded-full bg-red-500 text-white hover:bg-red-600 transition flex items-center justify-center" title="Delete">
        <i data-lucide="trash-2" class="w-4 h-4"></i>
    </button>
</div>
