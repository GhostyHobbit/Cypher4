<div class="{{ $isOpen ? 'block' : 'hidden' }} fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-background-default bg-opacity-50" @keydown.escape.window="open = false">
    <div class="bg-background-dark rounded-lg shadow-xl transform transition-all sm:max-w-lg sm:w-full p-6">
        <h2 class="text-xl font-medium text-text-default mb-4">Make a New Page</h2>

        <form wire:submit.prevent="save">
            <div>
                <x-input-label for="subject" :value="__('Subject')" />
                <x-text-input type="text" wire:model="subject" class="mt-1 block w-full" placeholder="Page Subject" required autofocus/>
                <x-input-error :messages="$errors->get('subject')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <button type="button" wire:click="$set('isOpen', false)">Cancel</button>
                <x-primary-button class="ml-3">Save Page</x-primary-button>
            </div>
        </form>
    </div>
</div>
