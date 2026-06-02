<?php

namespace App\View\Components\Entries;

use App\Domain\Stacks\Repositories\StackRepository;
use App\Models\Stack;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class AddEntryModal extends Component
{
    public ?Stack $stack;
    public ?Collection $stacks;

    /**
     * Create a new component instance.
     */
    public function __construct(
        ?Stack $stack = null,
        private StackRepository $stackRepository,
    ){
        $this->stack = $stack;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $this->stacks = $this->stack ? null : $this->stackRepository->getStacks();

        return view('components.entries.add-entry-modal')->with([
            'stacks' => $this->stacks,
        ]);
    }
}
