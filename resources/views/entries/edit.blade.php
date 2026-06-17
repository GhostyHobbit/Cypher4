<x-app-layout>
    <div class="m-16" x-data="{ edit: false }">
        <div class="grid grid-cols-12 items-start">
            <div class="flex items-end pb-8 col-span-10 relative">
                <div class="relative h-36 w-[60%] group" x-data>
                    <img src="{{ !empty($entry->cover_image) ? asset('storage/' . $entry->cover_image) : asset('images/entry_default.jpg') }}" class="h-full w-full object-cover rounded-lg" alt="{{ $entry->title }}"/>
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
                <div class="flex items-center absolute bottom-6 -left-3 group cursor-pointer bg-background-default pt-3 pb-1 px-3 rounded-xl" x-show="!edit" @click="edit = true">
                    <h1 class="text-3xl font-bold">{{ $entry->title }}</h1>
                    <x-icons.edit class="fill-transparent ml-1 mb-3 group-hover:fill-text-default transition-colors"/>
                </div>
            </div>

            <form x-show="edit" x-cloak @click.away="if (edit) { $el.submit() }" action="{{ route('entries.update', $entry->id) }}" method="POST" class="col-span-10 mb-4 mr-8">
                @csrf
                @method('PATCH')
                <x-text-input id="title" class="w-full text-xl" type="text" name="title" value="{{ $entry->title }}" x-effect="if (edit) $nextTick(() => $el.focus())" @keydown.escape="edit = false"/>
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </form>

            <div class="col-span-2">
                @if(!is_null($entry->stack_id))
                    <x-link-button href="{{ route('stacks.show', $entry->stack_id) }}" :cat="false">Back to stack</x-link-button>
                @else
                    <x-link-button href="{{ route('home') }}" :cat="false">Back to home</x-link-button>
                @endif
            </div>
        </div>

        <livewire:entry-editor :entryId="$entry->id"/>
    </div>
</x-app-layout>
