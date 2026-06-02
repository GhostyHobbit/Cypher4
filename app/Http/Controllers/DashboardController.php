<?php

namespace App\Http\Controllers;

use App\Domain\Entries\Repositories\EntryRepository;
use App\Domain\Stacks\Repositories\StackRepository;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private readonly EntryRepository $entryRepository,
        private readonly StackRepository $stackRepository,
    ){}

    public function index(): View
    {
        $stacks = $this->stackRepository->getStacks();
        $entries = $this->entryRepository->getStacklessEntries();

        return view('welcome')->with([
            'entries' => $entries,
            'stacks' => $stacks,
        ]);
    }
}
