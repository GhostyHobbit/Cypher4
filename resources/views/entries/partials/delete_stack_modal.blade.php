<div x-show="openModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-background-default bg-opacity-50" @keydown.escape.window="openModal = false">
    @if($entries->count() > 0)
        <div @click.away="openModal = false" class="bg-background-dark border border-red-800 rounded-lg shadow-xl transform transition-all sm:max-w-lg sm:w-full p-6">
            <div class="flex items-center mb-2">
                <x-icons.triangle-exclamation class="h-8 w-8 fill-red-800 mr-3" />
                <h2 class="text-xl font-bold text-text-default">Delete {{ $stack->title }}?</h2>
            </div>
            <p class="mb-4 text-text-light">{{ $stack->title }} has one or more entries in it. If you want to keep these entries, take them out of this stack before deleting it.</p>
            <p class="mb-4 text-text-light">Any entries will be <strong>permanently</strong> deleted together with the stack itself.</p>

            <div class="w-full flex items-center justify-end">
                <button class="text-text-light mr-5" @click="openModal = false">Cancel</button>
                <form action="{{ route('stacks.destroy', $stack->id) }}" method="POST" class="bg-red-900 text-text-default py-1 px-4 rounded-lg">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete Stack and Entries</button>
                </form>
            </div>
        </div>
    @else
        <div @click.away="openModal = false" class="bg-background-dark rounded-lg shadow-xl transform transition-all sm:max-w-lg sm:w-full p-6">
            <h2 class="text-xl font-bold text-text-default mb-2">Delete {{ $stack->title }}?</h2>
            <p class="mb-4 text-text-light">Are you sure you want to delete {{ $stack->title }}? This stack will be <strong>permanently</strong> deleted.</p>

            <div class="w-full flex items-center justify-end">
                <button class="text-text-light mr-5" @click="openModal = false">Cancel</button>
                <form action="{{ route('stacks.destroy', $stack->id) }}" method="POST" class="bg-red-900 text-text-default py-1 px-4 rounded-lg">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete Stack</button>
                </form>
            </div>
        </div>
    @endif
</div>
