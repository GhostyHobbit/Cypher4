<div class="m-10">
    <div class="static">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="flex">
                    <a href="{{ route('home') }}">
                        <h1 class="text-xl font-bold text-text-light opacity-50">{{ $journal->title }}</h1>
                    </a>
                    <p class="text-xl font-bold text-text-light opacity-50 ml-3 mr-5"> > </p>
                </div>
                @if($pageContent)
                    <div class="col-span-10 flex items-end">
                        <div class="flex items-center group">
                            <h1 class="text-3xl font-bold">{{ $pageContent->subject }}</h1>
                            <x-icons.edit class="fill-transparent ml-1 mb-3 group-hover:fill-text-default"/>
                        </div>
                        <p class="text-text-light">{{ $pageContent->created_at->isoFormat('DD MMM YYYY') }}</p>
                    </div>
                @else
                    <h1 class="text-3xl font-bold">Create your first page</h1>
                @endif
            </div>
            <div class="flex items-center gap-4">
                <button wire:click="previousPage" @disabled($currentPage === 1) class="bg-accent px-2 rounded-lg disabled:bg-background-light disabled:text-text-light"><<<</button>
                <span>Page {{ $hasPages ? $currentPage : 0 }} / {{ $pageCount }}</span>
                <button wire:click="nextPage" @disabled($currentPage === $pageCount) class="bg-accent px-2 rounded-lg disabled:bg-background-light disabled:text-text-light">>>></button>

                <div x-data="{openModal: false}">
                    <div class="bg-background-light p-2 rounded-lg cursor-pointer" @click="openModal = true">
                        <x-icons.trash class="h-5 w-5 fill-text-default hover:fill-red-500" />
                    </div>
                    @include('journals.partials.delete_page_modal', ['page' => $pageContent])
                </div>
            </div>
        </div>

        @if(!$hasPages)
            <div class="empty-state flex flex-col items-center justify-center h-[60vh]">
                <h3 class="font-semibold text-xl">This journal is empty</h3>
                <p class="mb-6">To start using this journal, you need to write your first page.</p>

                <button wire:click="$dispatch('open-create-page-modal', { journalId: {{ $journalId }} })" class="px-4 py-2 rounded-md font-bold text-md text-center bg-accent text-text-default">
                    Write First Page
                </button>
            </div>
        @endif

        @if($hasPages)
            <div class="mt-6">
                @if(!$isEditing)
                    <div wire:click="$set('isEditing', true)"
                         class="prose max-w-none w-full px-8 py-2 cursor-pointer rounded-lg min-h-48 shadow-inner">
                        <div class="mt-6 bg-[repeating-linear-gradient(_var(--pattern-fg)_0,_var(--pattern-fg)_3px,_transparent_0,_transparent_50%)] bg-[size:100px_100px] bg-fixed [--pattern-fg:rgb(var(--color-bg-light))]">
                            <div class="px-1">
                                {!! !empty($content) ? $content : '<p class="text-text-light italic opacity-50">Click here to start writing on this page...</p>' !!}
                            </div>
                        </div>
                    </div>
                @else
                    @include('journals.partials.page-editor')
                @endif
            </div>
        @endif

        <livewire:create-page-modal />
    </div>
    <div wire:click="$dispatch('open-create-page-modal', { journalId: {{ $journalId }} })" class="bg-accent p-1 rounded-full absolute right-6 bottom-4 cursor-pointer">
        <x-icons.plus class="w-8 h-8 fill-text-default" />
    </div>
</div>
