<x-app-layout>
    <div class="m-10">
        <div x-data="{edit: false}">
            <div class="flex items-center justify-between pb-8 col-span-10" x-show="!edit">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex">
                        <h1 class="text-xl font-bold text-text-light opacity-50">Home</h1>
                        <p class="text-xl font-bold text-text-light opacity-50 ml-3 mr-5"> > </p>
                    </a>
                    <div class="flex items-center col-span-10 group" @click="edit=true">
                        <h1 class="text-3xl font-bold">{{ $stack->title }}</h1>
                        <x-icons.edit class="fill-transparent ml-1 mb-3 group-hover:fill-text-default"/>
                    </div>
                </div>
                <div x-data="{ open: false, openModal: false }" class="flex">
                    <x-link-button @click="open = true" class="cursor-pointer" :cat="false">+ New Entry</x-link-button>
                    <x-entries.add-entry-modal :stack="$stack"/>
                    <div class="bg-background-light p-2 rounded-lg mt-2.5 ml-3 cursor-pointer" @click="openModal = true">
                        <x-icons.trash class="h-5 w-5 fill-text-default hover:fill-red-500" />
                    </div>
                    @include('entries.partials.delete_stack_modal', ['entries' => $entries, 'stack' => $stack])
                </div>
            </div>
            <form x-show="edit" x-cloak @click.away="if (edit) { $el.submit() }" action="{{ route('stacks.update', $stack->id) }}" method="POST" class="col-span-10 mb-4 mr-8">
                @csrf
                @method('PATCH')
                <x-text-input id="title" class="w-full text-xl" type="text" name="title" value="{{ $stack->title }}" x-effect="if (edit) $nextTick(() => $el.focus())" @keydown.escape="edit = false"/>
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </form>
        </div>
        <div class="p-4 w-full grid grid-cols-5 gap-y-10">
            @foreach($entries as $entry)
                <div x-data="{ menuOpen: false, openModal: false, openEdit: false }">
                    <a href="{{ route('entries.edit', $entry->id) }}" class="flex flex-col items-center">
                        <div class="relative h-44 aspect-square group" @mouseleave="menuOpen = false">
                            <img src="{{ !empty($entry->cover_image) ? asset('storage/' . $entry->cover_image) : asset('images/apollopfp.jpg') }}" class="h-full w-full object-cover rounded-lg" alt="{{ $entry->title }}"/>
                            <button type="button" @click.prevent.stop="menuOpen = !menuOpen" class="absolute -top-1 -right-1 bg-background-default md:bg-transparent group-hover:bg-background-default rounded-lg p-1 z-10 transition-colors duration-150">
                                <x-icons.ellipsis class="h-4 w-4 rotate-90 fill-text-default md:fill-transparent group-hover:fill-text-default transition-colors duration-150"/>
                            </button>
                            <div x-show="menuOpen" x-cloak @click.away="menuOpen = false" class="absolute right-0 top-8 mt-1 w-44 bg-background-light rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-20 overflow-hidden py-1 border border-accent/20">
                                <button type="button" @click.prevent.stop="$refs.fileInput.click(); menuOpen = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-xs text-text-default hover:bg-background-dark transition font-medium">
                                    <x-icons.edit class="h-3.5 w-3.5 fill-current"/>
                                    <span>Change cover image</span>
                                </button>
                                <button type="button" @click.prevent.stop="openEdit = true; menuOpen = false; " class="flex w-full items-center gap-2 px-3 py-2 text-left text-xs text-text-default hover:bg-background-dark transition font-medium">
                                    <x-icons.list-ul class="h-3.5 w-3.5 fill-current"/>
                                    <span>Edit entry</span>
                                </button>
                                <button type="button" @click.prevent.stop="menuOpen = false; openModal = true"
                                        class="flex w-full items-center gap-2 px-3 py-2 text-left text-xs text-red-500 hover:bg-background-dark transition font-medium">
                                    <x-icons.trash class="h-3.5 w-3.5 fill-current"/>
                                    <span>Delete entry</span>
                                </button>
                            </div>
                            <form action="{{ route('photo.upload', ['type' => 'entry', 'id' => $entry->id]) }}" method="POST" enctype="multipart/form-data" class="hidden">
                                @csrf
                                <input type="file" name="photo" x-ref="fileInput" @change="$el.form.submit()" accept="image/*">
                            </form>
                        </div>
                        <div class="max-w-44 relative"
                             x-data="{showTooltip: false, isHovered: false, checkAndShow() { if (!this.isHovered) return; const p = this.$refs.titleText; if (p && p.scrollWidth > p.clientWidth) {this.showTooltip = true;}}}"
                             @mouseenter="isHovered = true" @mouseenter.debounce.1000ms="checkAndShow()" @mouseleave="isHovered = false; showTooltip = false">
                            <p x-ref="titleText" class="text-lg mt-2 truncate">{{ $entry->title }}</p>

                            <div x-show="showTooltip" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 -translate-x-1/2" x-transition:enter-end="opacity-100 scale-100 -translate-x-1/2" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 -translate-x-1/2" x-transition:leave-end="opacity-0 scale-95 -translate-x-1/2"
                                 class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-max max-w-xs rounded-md bg-background-light p-2 text-sm text-text-default shadow-lg border border-accent_purple z-50 whitespace-normal break-words">
                                {{ $entry->title }}
                            </div>
                        </div>
                    </a>
                    <x-entries.edit-entry-modal :stacks="$stacks" :stack="$stack" :entry="$entry"/>
                    @include('entries.partials.delete_entry_confirm_modal')
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
