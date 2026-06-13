<div x-show="openModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-background-default bg-opacity-50" @keydown.escape.window="open = false">
    <div @click.away="openModal = false" class="bg-background-dark rounded-lg shadow-xl transform transition-all sm:max-w-lg sm:w-full p-6">
        <h2 class="text-xl font-bold text-text-default mb-2">Delete {{ $page->subject }}?</h2>
        <p class="mb-4 text-text-light">Are you sure you want to delete {{ $page->subject }}? This page will be <strong>permanently</strong> deleted from this journal.</p>

        <div class="w-full flex items-center justify-end">
            <button class="text-text-light mr-5" @click="openModal = false">Cancel</button>
            <form wire:submit.prevent="deletePage({{ $page->id }})" method="POST" class="bg-red-900 text-text-default py-1 px-4 rounded-lg">
                @csrf
                @method('DELETE')
                <button type="submit" @click="openModal = false">Delete Page</button>
            </form>
        </div>
    </div>
</div>
