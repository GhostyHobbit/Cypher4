<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Home Dash') }}
        </h2>
    </x-slot>

    <div class="p-12 grid grid-cols-12 gap-10 items-start">
        <div class="col-span-8 grid grid-cols-12 gap-8 gap-x-12">
            <div class="w-full p-6 lg:p-8 bg-background-light rounded-lg col-span-12 max-h-[50vh] overflow-hidden overflow-y-scroll scrollbar-hide">
                <div class="mb-10">
                    <h1 class="text-3xl font-bold">My Stacks</h1>
                    <div class="p-4 w-full grid grid-cols-4 gap-y-10 gap-x-11 mt-4">
                        @foreach($stacks as $stack)
                            <a href="{{ route('stacks.show', $stack->id) }}" class="flex flex-col items-center">
                                <div class="max-w-32 relative"
                                     x-data="{showTooltip: false, isHovered: false, checkAndShow() { if (!this.isHovered) return; const p = this.$refs.titleText; if (p && p.scrollWidth > p.clientWidth) {this.showTooltip = true;}}}"
                                     @mouseenter="isHovered = true" @mouseenter.debounce.1000ms="checkAndShow()" @mouseleave="isHovered = false; showTooltip = false">
                                    <p x-ref="titleText" class="text-lg mb-8 truncate">{{ $stack->title }}</p>

                                    <div x-show="showTooltip" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 -translate-x-1/2" x-transition:enter-end="opacity-100 scale-100 -translate-x-1/2" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 -translate-x-1/2" x-transition:leave-end="opacity-0 scale-95 -translate-x-1/2"
                                         class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-max max-w-xs rounded-md bg-background-light p-2 text-sm text-text-default shadow-lg border border-accent_purple z-50 whitespace-normal break-words">
                                        {{ $stack->title }}
                                    </div>
                                </div>
                                <div class="relative aspect-square w-32">
                                    <div class="aspect-square w-32 bg-background-dark rounded-lg rotate-[36deg] absolute shadow-md"></div>
                                    <div class="aspect-square w-32 bg-background-default rounded-lg rotate-[18deg] absolute shadow-md"></div>
                                    <div class="relative w-32 aspect-square group" x-data>
                                        <img src="{{ !empty($stack->cover_image) ? asset('storage/' . $stack->cover_image) : asset('images/apollopfp.jpg') }}" class="h-full w-full object-cover rounded-lg" alt="{{ $stack->title }}"/>
                                        <button type="button"
                                                @click.prevent.stop="$refs.fileInput.click()"
                                                class="absolute -top-1 -right-1 bg-background-default md:bg-transparent group-hover:bg-background-default rounded-lg p-1 z-10">
                                            <x-icons.edit class="h-3 w-3 fill-text-default md:fill-transparent group-hover:fill-text-default"/>
                                        </button>
                                        <form action="{{ route('photo.upload', ['type' => 'stack', 'id' => $stack->id]) }}" method="POST" enctype="multipart/form-data" class="hidden">
                                            @csrf
                                            <input type="file" name="photo" x-ref="fileInput" @change="$el.form.submit()" accept="image/*">
                                        </form>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <h1 class="text-3xl font-bold mb-8">My Entries</h1>
                <div class="p-4 w-full grid grid-cols-5 gap-x-11 gap-y-6">
                    @foreach($entries as $entry)
                        <a href="{{ route('entries.edit', $entry->id) }}" class="flex flex-col items-center">
                            <div class="relative h-28 aspect-square group" x-data>
                                <img src="{{ !empty($entry->cover_image) ? asset('storage/' . $entry->cover_image) : asset('images/apollopfp.jpg') }}" class="h-full w-full object-cover rounded-lg" alt="{{ $entry->title }}"/>
                                <button type="button"
                                        @click.prevent.stop="$refs.fileInput.click()"
                                        class="absolute -top-1 -right-1 bg-background-default md:bg-transparent group-hover:bg-background-default rounded-lg p-1 z-10">
                                    <x-icons.edit class="h-3 w-3 fill-text-default md:fill-transparent group-hover:fill-text-default"/>
                                </button>
                                <form action="{{ route('photo.upload', ['type' => 'entry', 'id' => $entry->id]) }}" method="POST" enctype="multipart/form-data" class="hidden">
                                    @csrf
                                    <input type="file" name="photo" x-ref="fileInput" @change="$el.form.submit()" accept="image/*">
                                </form>
                            </div>                            <div class="max-w-28 relative"
                                 x-data="{showTooltip: false, isHovered: false, checkAndShow() { if (!this.isHovered) return; const p = this.$refs.titleText; if (p && p.scrollWidth > p.clientWidth) {this.showTooltip = true;}}}"
                                 @mouseenter="isHovered = true" @mouseenter.debounce.1000ms="checkAndShow()" @mouseleave="isHovered = false; showTooltip = false">
                                <p x-ref="titleText" class="text-lg mt-2 truncate">{{ $entry->title }}</p>

                                <div x-show="showTooltip" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 -translate-x-1/2" x-transition:enter-end="opacity-100 scale-100 -translate-x-1/2" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 -translate-x-1/2" x-transition:leave-end="opacity-0 scale-95 -translate-x-1/2"
                                     class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-max max-w-xs rounded-md bg-background-light p-2 text-sm text-text-default shadow-lg border border-accent_purple z-50 whitespace-normal break-words">
                                    {{ $entry->title }}
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="col-span-4 bg-background-light rounded-lg h-64 p-6">
            </div>

            <div class="col-span-4 bg-background-light rounded-lg h-64 p-6">
            </div>

            <div class="col-span-4 bg-background-light rounded-lg h-64 p-6">
            </div>
        </div>

        <div class="col-span-4 bg-background-light rounded-lg p-6 h-full">
        </div>

    </div>
</x-app-layout>
