@props(['image', 'title', 'location', 'price', 'type', 'slug' => '#', 'description' => ''])

<div class="rounded-[1.5rem] md:rounded-[2rem] overflow-hidden shadow-sm bg-brand-white border border-gray-100 flex flex-col hover:shadow-xl transition duration-300 p-2 gap-2 h-fit group">
    {{-- Image Container --}}
    <a href="{{ route('property.view', $slug) }}" class="h-52 md:h-64 mb-2 relative overflow-hidden rounded-[1.5rem] block">
        <img loading="lazy" decoding="async" src="{{ $image }}" alt="{{ $title }}" class="block absolute inset-0 w-full h-full object-cover pointer-events-none z-0 transition duration-700 group-hover:scale-110">

        {{-- Status Badge --}}
        <div class="absolute top-4 right-4">
            <span class="{{ $type === 'Sale' ? 'bg-brand-black text-white' : 'bg-primary text-brand-black' }} px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider shadow-sm">
                For {{ $type }}
            </span>
        </div>
    </a>

    {{-- Content --}}
    <div class="flex-1 flex flex-col px-2 pb-2">
        <div class="flex flex-col mb-4">
            <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mb-1">{{ $location }}</p>
            <h3 class="text-xl font-bold text-brand-black mb-1">{{ $title }}</h3>
            <p class="text-gray-500 text-xs line-clamp-2 leading-relaxed h-fit mb-2">
                {{ $description }}
            </p>
            <p class="font-heading font-bold text-2xl text-brand-black mt-3">{{ $price }}</p>
        </div>

        <a href="{{ route('property.view', $slug) }}" class="mt-auto bg-brand-black text-primary text-center rounded-full py-4 px-6 font-bold text-[10px] uppercase tracking-[0.2em] hover:bg-gray-800 transition duration-300">
            VIEW DETAILS
        </a>
    </div>
</div>
