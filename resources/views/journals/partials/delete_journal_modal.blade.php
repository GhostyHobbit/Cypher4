<div x-show="openModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-background-default bg-opacity-50" @keydown.escape.window="openModal = false">
    <div @click.away="openModal = false" class="bg-background-dark border border-red-800 rounded-lg shadow-xl transform transition-all sm:max-w-lg sm:w-full p-6">
        <div class="flex items-center mb-2">
            <x-icons.triangle-exclamation class="h-8 w-8 fill-red-800 mr-3" />
            <h2 class="text-xl font-bold text-text-default">Delete {{ $journal->title }}?</h2>
        </div>
        <p class="mb-4 text-text-light">{{ $journal->title }} has one or more pages in it.</p>
        <p class="mb-4 text-text-light">Any pages will be <strong>permanently</strong> deleted together with the stack itself.</p>

        <div class="w-full flex items-center justify-end">
            <button class="text-text-light mr-5" @click="openModal = false">Cancel</button>
            <form action="{{ route('journals.destroy', $journal->id) }}" method="POST" class="bg-red-900 text-text-default py-1 px-4 rounded-lg">
                @csrf
                @method('DELETE')
                <button type="submit">Delete Journal and Pages</button>
            </form>
        </div>
    </div>
</div>
