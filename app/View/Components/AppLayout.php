<?php

namespace App\View\Components;

use App\Domain\Entries\Repositories\EntryRepository;
use App\Domain\Stacks\Repositories\StackRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    public function __construct(
        private StackRepository $stackRepository,
        private EntryRepository $entryRepository,
    ) {}

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $stacks = $this->stackRepository->getStacks();
        $entries = $this->entryRepository->getStacklessEntries();
        $user = Auth::user();

        return view('layouts.app')->with([
            'stacks' => $stacks,
            'entries' => $entries,
            'user' => $user,
        ]);
    }
}
