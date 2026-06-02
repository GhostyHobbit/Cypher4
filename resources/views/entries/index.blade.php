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
                <div x-data="{ open: false }">
                    <x-link-button @click="open = true" class="cursor-pointer" :cat="false">+ New Entry</x-link-button>
                    <x-entries.add-entry-modal :stack="$stack"/>
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
                <a href="{{ route('entries.edit', $entry->id) }}" class="flex flex-col items-center">
                    <div class="relative h-44 aspect-square group" x-data>
                        <img src="{{ !empty($entry->cover_image) ? asset('storage/' . $entry->cover_image) : asset('images/apollopfp.jpg') }}" alt="entry" class="w-44 aspect-square object-cover rounded-lg"/>
                        <button type="button"
                                @click.prevent.stop="$refs.fileInput.click()"
                                class="absolute -top-1 -right-1 bg-background-default md:bg-transparent group-hover:bg-background-default rounded-lg p-1 z-10">
                            <x-icons.edit class="h-6 w-6 fill-text-default md:fill-transparent group-hover:fill-text-default"/>
                        </button>
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
            @endforeach
        </div>
    </div>
</x-app-layout>
