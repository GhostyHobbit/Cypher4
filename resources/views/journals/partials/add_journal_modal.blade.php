<div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-background-default bg-opacity-50" @keydown.escape.window="open = false">
    <div @click.away="open = false; dropdownOpen = false" class="bg-background-dark rounded-lg shadow-xl transform transition-all sm:max-w-lg sm:w-full p-6">
        <h2 class="text-xl font-medium text-text-default mb-4">Make a New Journal</h2>

        <form action="{{ route('journals.store') }}" method="POST">
            @csrf
            <input type="hidden" name="stack_id" value="{{ isset($stack) ? $stack->id : '' }}" />

            <div>
                <x-input-label for="title" :value="__('Title')" />
                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" placeholder="Journal title..." required autofocus/>
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <button type="button" @click="open = false" class="px-4 py-2 text-sm font-medium text-text-light hover:text-text-default">Cancel</button>
                <x-primary-button class="ml-3">Create Journal</x-primary-button>
            </div>
        </form>
    </div>
</div>
