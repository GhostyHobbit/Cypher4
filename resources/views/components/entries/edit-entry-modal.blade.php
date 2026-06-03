<div x-show="openEdit" x-cloak class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-background-default bg-opacity-50" @keydown.escape.window="openEdit = false">
    <div @click.prevent.stop.away="openEdit = false" class="bg-background-dark rounded-lg shadow-xl transform transition-all sm:max-w-lg sm:w-full p-6">
        <h2 class="text-xl font-medium text-text-default mb-4" @click.prevent.stop>Edit Entry</h2>

        <form action="{{ route('entries.update', $entry->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <div>
                <x-input-label for="title" :value="__('Title')" />
                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" value="{{ $entry->title }}" required autofocus/>
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="stack_id" :value="__('Assign to Stack (Optional)')" />
                <select id="stack_id" name="stack_id" class="mt-1 w-full rounded-md bg-background-light text-text-default focus:border-accent_purple focus:ring-accent_purple shadow-sm py-3">
                    <option value="">None</option>
                    @foreach($stacks as $availableStack)
                        <option value="{{ $availableStack->id }}"
                            @selected($stack !== null && $availableStack->id === $stack->id)>
                            {{ $availableStack->title }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('stack_id')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <button type="button" @click.prevent.stop="openEdit = false" class="px-4 py-2 text-sm font-medium text-text-light hover:text-text-default">Cancel</button>
                <x-primary-button class="ml-3">Edit Entry</x-primary-button>
            </div>
        </form>
    </div>
</div>
