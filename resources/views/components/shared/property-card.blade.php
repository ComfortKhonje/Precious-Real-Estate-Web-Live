@props([
    'image',
    'location' => 'Location',
    'price' => 'MWK 0',
    'description' => 'A short description will be here so that users understand the property.',
    'status' => 'For Rent', // 'For Rent' or 'For Sale'
    'statusColor' => 'bg-primary',
    'href' => '#',
])

<div
    class="bg-white rounded-[1.5rem] md:rounded-[2rem] overflow-hidden shadow-sm border border-gray-100 flex flex-col hover:shadow-xl transition duration-300 p-2 gap-2 h-fit group">
    {{-- Image Container --}}
    <div class="h-52 md:h-64 mb-2 relative overflow-hidden rounded-[1.5rem]">
        <img src="{{ $image }}" alt="{{ $location }}"
            class="block absolute inset-0 w-full h-full object-cover pointer-events-none z-0 transition duration-700 group-hover:scale-110">

        {{-- Status Badge --}}
        <div class="absolute top-4 right-4">
            <span
                class="{{ $status === 'For Sale' ? 'bg-primary text-brand-black' : 'bg-primary text-brand-black' }} px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider shadow-sm">
                {{ $status }}
            </span>
        </div>
    </div>

    {{-- Content --}}
    <div class="flex-1 flex flex-col">
        <div class="flex flex-col mb-4">
            <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-1">{{ $location }}</p>
            <h3 class="text-2xl font-heading text-brand-black mb-2">{{ $price }}</h3>
            <p class="text-gray-500 text-sm line-clamp-2 leading-relaxed">{{ $description }}</p>
        </div>

        <a href="{{ $href }}"
            class="mt-auto bg-brand-black text-white text-center rounded-full py-3 px-6 font-bold text-xs uppercase tracking-widest hover:bg-gray-800 transition duration-300">
            VIEW DETAILS
        </a>
    </div>
</div>
<a href="{{ $href }}"
