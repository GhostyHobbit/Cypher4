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
                                        <img src="{{ !empty($stack->cover_image) ? asset('storage/' . $stack->cover_image) : asset('images/stack_default.jpg') }}" class="h-full w-full object-cover rounded-lg" alt="{{ $stack->title }}"/>
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
                        <div x-data="{ menuOpen: false, openModal: false, openEdit: false }">
                            <a href="{{ route('entries.edit', $entry->id) }}" class="flex flex-col items-center">
                                <div class="relative h-28 aspect-square group" @mouseleave="menuOpen = false">
                                    <img src="{{ !empty($entry->cover_image) ? asset('storage/' . $entry->cover_image) : asset('images/entry_default.jpg') }}" class="h-full w-full object-cover rounded-lg" alt="{{ $entry->title }}"/>
                                    <button type="button" @click.prevent.stop="menuOpen = !menuOpen" class="absolute -top-1 -right-1 bg-background-default md:bg-transparent group-hover:bg-background-default rounded-lg p-1 z-10 transition-colors duration-150">
                                        <x-icons.ellipsis class="h-4 w-4 rotate-90 fill-text-default md:fill-transparent group-hover:fill-text-default transition-colors duration-150"/>
                                    </button>
                                    <div x-show="menuOpen" x-cloak @click.away="menuOpen = false" class="absolute -right-5 top-8 mt-1 w-44 bg-background-light rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-20 overflow-hidden py-1 border border-accent/20">
                                        <button type="button" @click.prevent.stop="$refs.fileInput.click(); menuOpen = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-xs text-text-default hover:bg-background-dark transition font-medium">
                                            <x-icons.edit class="h-3.5 w-3.5 fill-current"/>
                                            <span>Change cover image</span>
                                        </button>
                                        <form action="{{ route('photo.upload', ['type' => 'entry', 'id' => $entry->id]) }}" method="POST" enctype="multipart/form-data" class="hidden">
                                            @csrf
                                            <input type="file" name="photo" x-ref="fileInput" @change="$el.form.submit()" accept="image/*">
                                        </form>
                                        <button type="button" @click.prevent.stop="menuOpen = false; openEdit = true;" class="flex w-full items-center gap-2 px-3 py-2 text-left text-xs text-text-default hover:bg-background-dark transition font-medium">
                                            <x-icons.list-ul class="h-3.5 w-3.5 fill-current"/>
                                            <span>Edit entry</span>
                                        </button>
                                        <button type="button" @click.prevent.stop="menuOpen = false; openModal = true"
                                                class="flex w-full items-center gap-2 px-3 py-2 text-left text-xs text-red-500 hover:bg-background-dark transition font-medium">
                                            <x-icons.trash class="h-3.5 w-3.5 fill-current"/>
                                            <span>Delete entry</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="max-w-28 relative"
                                     x-data="{showTooltip: false, isHovered: false, checkAndShow() { if (!this.isHovered) return; const p = this.$refs.titleText; if (p && p.scrollWidth > p.clientWidth) {this.showTooltip = true;}}}"
                                     @mouseenter="isHovered = true" @mouseenter.debounce.1000ms="checkAndShow()" @mouseleave="isHovered = false; showTooltip = false">
                                    <p x-ref="titleText" class="text-lg mt-2 truncate">{{ $entry->title }}</p>

                                    <div x-show="showTooltip" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 -translate-x-1/2" x-transition:enter-end="opacity-100 scale-100 -translate-x-1/2" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 -translate-x-1/2" x-transition:leave-end="opacity-0 scale-95 -translate-x-1/2"
                                         class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-max max-w-xs rounded-md bg-background-light p-2 text-sm text-text-default shadow-lg border border-accent_purple z-50 whitespace-normal break-words">
                                        {{ $entry->title }}
                                    </div>
                                </div>
                            </a>
                            @include('entries.partials.delete_entry_confirm_modal')
                            <x-entries.edit-entry-modal :stacks="$stacks" :entry="$entry" />
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-span-4 bg-background-light rounded-lg h-64 overflow-hidden text-center">
                <p class="text-xl py-2 font-bold">Nature</p>
                <div class="h-44 w-full">
                    <img src="{{ asset('images/70437489499889.jpg') }}" class="object-contain"/>
                </div>
            </div>

            <div class="col-span-4 bg-background-light rounded-lg h-64 overflow-hidden text-center">
                <p class="text-xl py-2 font-bold">Art</p>
                <div class="h-44 w-full">
                    <img src="{{ asset('images/apollopfp.jpg') }}" class="object-contain"/>
                </div>
            </div>

            <div class="col-span-4 bg-background-light rounded-lg h-64 overflow-hidden text-center">
                <p class="text-xl py-2 font-bold">Tarot Spreads</p>
                <div class="h-44 w-full">
                    <img src="{{ asset('images/meep.png') }}" class="object-contain"/>
                </div>
            </div>
        </div>

        <div class="flex flex-col items-center col-span-4 bg-background-light rounded-lg p-6 max-h-[81.6vh] min-h-[81.6vh] w-full max-w-sm mx-auto">
            <div class="overflow-y-auto scrollbar-hide w-full">
                <h1 class="text-3xl font-bold mb-8">My Journals</h1>
                <div class="w-full grid grid-cols-2 gap-x-8 gap-y-6 justify-items-center justify-center content-start pr-1">
                    @foreach($journals as $journal)
                        <div x-data="{ menuOpen: false, openModal: false, openEdit: false }" class="w-full flex flex-col items-center">
                            <a href="{{ route('journals.show', $journal->id) }}" class="flex flex-col items-center group text-center relative w-full">
                                <div class="h-56 w-36 relative select-none shrink-0" @mouseleave="menuOpen = false">

                                    <div class="absolute inset-y-1 right-[-3px] w-4 bg-[#f4ebd0] rounded-r border-r border-y border-black/10 z-0"></div>
                                    <div class="absolute inset-y-2 right-[-5px] w-4 bg-[#eee1be] rounded-r border-r border-y border-black/10 z-0"></div>

                                    <div class="relative h-full w-full bg-background-dark rounded-l-md rounded-r-lg overflow-hidden shadow-lg border border-black/20 z-10 flex">
                                        <img src="{{ !empty($journal->cover_image) ? asset('storage/' . $journal->cover_image) : asset('images/journal_default.jpg') }}"
                                             class="absolute left-2 inset-0 h-full w-full object-cover rounded-l-md rounded-r-lg mix-blend-normal z-0"
                                             alt="{{ $journal->title }}"/>

                                        <div class="absolute inset-y-0 left-0 w-full bg-gradient-to-r from-black/5 to-transparent z-10 pointer-events-none"></div>
                                        <div class="absolute inset-y-0 left-4 w-[1px] bg-black/30 shadow-[1px_0_3px_rgba(255,255,255,0.1)] z-10 pointer-events-none"></div>
                                        <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/1 to-white/5 z-10 pointer-events-none"></div>
                                    </div>

                                    <div class="absolute inset-y-3 left-1 w-2 z-20 flex flex-col justify-between items-center pointer-events-none">
                                        <div class="h-full w-full opacity-80"
                                             style="background: repeating-linear-gradient(to bottom, #7f8c8d, #7f8c8d 2px, transparent 2px, transparent 14px);">
                                        </div>
                                    </div>
                                    <div class="absolute inset-y-3 left-0 w-2 z-20 flex flex-col justify-between items-center pointer-events-none">
                                        <div class="h-full w-full opacity-60"
                                             style="background: repeating-linear-gradient(to bottom, #bdc3c7, #bdc3c7 2px, transparent 2px, transparent 14px);">
                                        </div>
                                    </div>

                                    <button type="button" @click.prevent.stop="menuOpen = !menuOpen" class="absolute -top-1 right-[-4px] bg-background-default md:bg-transparent group-hover:bg-background-default rounded-lg p-1 z-30 transition-colors duration-150">
                                        <x-icons.ellipsis class="h-4 w-4 rotate-90 fill-text-default md:fill-transparent group-hover:fill-text-default transition-colors duration-150"/>
                                    </button>

                                    <div x-show="menuOpen" x-cloak @click.away="menuOpen = false" class="absolute right-0 top-8 mt-1 w-36 bg-background-light rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-40 overflow-hidden py-1 border border-accent/20">
                                        <button type="button" @click.prevent.stop="$refs.fileInput.click(); menuOpen = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-xs text-text-default hover:bg-background-dark transition font-medium">
                                            <x-icons.edit class="h-3.5 w-3.5 fill-current"/>
                                            <span>Change cover</span>
                                        </button>
                                        <button type="button" @click.prevent.stop="menuOpen = false; openEdit = true;" class="flex w-full items-center gap-2 px-3 py-2 text-left text-xs text-text-default hover:bg-background-dark transition font-medium">
                                            <x-icons.list-ul class="h-3.5 w-3.5 fill-current"/>
                                            <span>Edit journal</span>
                                        </button>
                                        <button type="button" @click.prevent.stop="menuOpen = false; openModal = true" class="flex w-full items-center gap-2 px-3 py-2 text-left text-xs text-red-500 hover:bg-background-dark transition font-medium">
                                            <x-icons.trash class="h-3.5 w-3.5 fill-current"/>
                                            <span>Delete journal</span>
                                        </button>
                                    </div>
                                </div>
                                <p class="mt-2 text-sm font-medium text-text-default truncate max-w-36">{{ $journal->title }}</p>
                            </a>

                            <form action="{{ route('photo.upload', ['type' => 'journal', 'id' => $journal->id]) }}" method="POST" enctype="multipart/form-data" class="hidden">
                                @csrf
                                <input type="file" name="photo" x-ref="fileInput" @change="$el.form.submit()" accept="image/*">
                            </form>

                            @include('journals.partials.delete_journal_modal', ['journal' => $journal])
{{--                            <x-journals.edit-journal-modal :journal="$journal" />--}}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
