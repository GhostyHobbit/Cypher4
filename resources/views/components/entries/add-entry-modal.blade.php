<div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-background-default bg-opacity-50" @keydown.escape.window="open = false">
    <div @click.away="open = false" class="bg-background-dark rounded-lg shadow-xl transform transition-all sm:max-w-lg sm:w-full p-6">
        <h2 class="text-xl font-medium text-text-default mb-4">Make a New Entry</h2>

        <form action="{{ route('entries.store') }}" method="POST">
            @csrf
            <div>
                <x-input-label for="title" :value="__('Title')" />
                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" placeholder="Entry title..." required autofocus/>
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            @if($stack)
                <input type="hidden" name="stack_id" value="{{ $stack->id }}">
            @else
                <div class="mt-4">
                    <x-input-label for="stack_id" :value="__('Assign to Stack (Optional)')" />
                    <select id="stack_id" name="stack_id" class="mt-1 w-full rounded-md bg-background-light text-text-default focus:border-accent_purple focus:ring-accent_purple shadow-sm py-3">
                        <option value="">None</option>
                        @foreach($stacks as $availableStack)
                            <option value="{{ $availableStack->id }}">{{ $availableStack->title }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('stack_id')" class="mt-2" />
                </div>
            @endif

            <div class="mt-6 flex justify-end">
                <button type="button" @click="open = false" class="px-4 py-2 text-sm font-medium text-text-light hover:text-text-default">Cancel</button>
                <x-primary-button class="ml-3">Create Entry</x-primary-button>
            </div>
        </form>
    </div>
</div>
