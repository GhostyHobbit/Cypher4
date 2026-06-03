<?php

namespace App\View\Components\Entries;

use App\Domain\Entries\Repositories\EntryRepository;
use App\Domain\Stacks\Repositories\StackRepository;
use App\Models\Entry;
use App\Models\Stack;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class EditEntryModal extends Component
{
    public ?Stack $stack;

    public ?Entry $entry;

    public Collection $stacks;

    /**
     * Create a new component instance.
     */
    public function __construct(
        ?Stack $stack,
        ?Entry $entry,
        private StackRepository $stackRepository,
        private EntryRepository $entryRepository,
    ) {
        $this->stack = $stack;
        $this->entry = $entry;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $this->stacks = $this->stackRepository->getStacks();
        $entry = $this->entryRepository->getEntryById($this->entry->id);

        return view('components.entries.edit-entry-modal')->with([
            'stacks' => $this->stacks,
            'entry' => $entry,
        ]);
    }
}
