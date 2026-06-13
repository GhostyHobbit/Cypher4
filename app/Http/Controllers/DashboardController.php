<?php

namespace App\Http\Controllers;

use App\Domain\Entries\Repositories\EntryRepository;
use App\Domain\Journals\Repositories\JournalRepository;
use App\Domain\Stacks\Repositories\StackRepository;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private readonly EntryRepository $entryRepository,
        private readonly StackRepository $stackRepository,
        private readonly JournalRepository $journalRepository,
    ) {}

    public function index(): View
    {
        $stacks = $this->stackRepository->getStacks();
        $entries = $this->entryRepository->getStacklessEntries();
        $journals = $this->journalRepository->getUserJournals();

        return view('welcome')->with([
            'entries' => $entries,
            'stacks' => $stacks,
            'journals' => $journals,
        ]);
    }
}
