@props([
'options' => [],
'placeholder' => 'Select an option',
'name' => null,
'value' => null,
])

<div
    x-data="{
        open: false,
        selected: '{{ $value }}',
        selectedLabel: '{{ $placeholder }}',
        options: @js($options),

        init() {
            const existing = this.options.find(
                option => option.value == this.selected
            )

            if (existing) {
                this.selectedLabel = existing.label
            }
        },

        selectOption(option) {
            this.selected = option.value
            this.selectedLabel = option.label
            this.open = false

            this.$refs.input.value = option.value

            this.$dispatch('change', option.value)
        }
    }"

    class="relative z-50 w-full">
    {{-- Hidden Form Input --}}
    <input
        x-ref="input"
        type="hidden"
        name="{{ $name }}"
        value="{{ $value }}">

    {{-- Trigger --}}
    <button
        type="button"

        @click="open = !open"
        @click.away="open = false"

        class="
            relative
            flex
            w-full
            items-center
            justify-between

            rounded-2xl
            border
            border-[#E5D3B3]

            bg-white
            px-5
            py-4

            text-left
            text-sm
            font-semibold
            text-[#222222]

            shadow-sm
            transition-all
            duration-300

            hover:border-[#C6A16E]
            hover:shadow-md

            focus:outline-none
            focus:ring-4
            focus:ring-[#C6A16E]/15
        "

        {{ $attributes }}>
        <span
            class="truncate"
            :class="selected ? 'text-[#222222]' : 'text-[#999999]'"
            x-text="selectedLabel"></span>

        {{-- Chevron --}}
        <svg
            class="h-5 w-5 text-[#C6A16E] transition-transform duration-300"
            :class="{ 'rotate-180': open }"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24">
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2.5"
                d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    {{-- Dropdown --}}
    <div
        x-show="open"

        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-1 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"

        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"

        class="
            absolute
            z-[9999]
            mt-3
            w-full

            overflow-hidden
            rounded-2xl

            border
            border-[#F0E2CB]

            bg-white

            shadow-[0_20px_60px_rgba(0,0,0,0.12)]
        "

        x-cloak>
        <div class="max-h-72 overflow-y-auto py-2">
            <template x-for="option in options" :key="option.value">
                <button
                    type="button"

                    @click="selectOption(option)"

                    class="
                        flex
                        w-full
                        items-center
                        justify-between

                        px-5
                        py-3.5

                        text-left
                        text-sm
                        font-medium
                        text-[#2B2B2B]

                        transition-all
                        duration-200

                        hover:bg-[#C6A16E]/10
                        hover:text-[#A67C52]
                    ">
                    <span x-text="option.label"></span>

                    {{-- Check Icon --}}
                    <svg
                        x-show="selected === option.value"
                        class="h-4 w-4 text-[#C6A16E]"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="3"
                            d="M5 13l4 4L19 7" />
                    </svg>
                </button>
            </template>
        </div>
    </div>
</div>