<?php

namespace App\Http\Controllers;

use App\Domain\Entries\Repositories\EntryRepository;
use App\Domain\Stacks\Actions\CreateStackAction;
use App\Domain\Stacks\Actions\UpdateStackAction;
use App\Domain\Stacks\Repositories\StackRepository;
use App\Models\Stack;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StackController extends Controller
{
    public function __construct(
        private readonly EntryRepository $entryRepository,
        private readonly StackRepository $stackRepository,
        private readonly CreateStackAction $createStackAction,
        private readonly UpdateStackAction $updateStackAction,
    ) {}

    public function show(int $stackId): View
    {
        $stack = $this->stackRepository->getStackById($stackId);
        $stacks = $this->stackRepository->getStacks();
        $entries = $this->entryRepository->getEntriesByStackId($stackId);

        return view('entries.index')->with([
            'stack' => $stack,
            'entries' => $entries,
            'stacks' => $stacks,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        return $this->createStackAction->handle([
            'title' => $request['title'],
            'user_id' => Auth::user()->id,
        ]);
    }

    public function update(Request $request, Stack $stack): RedirectResponse
    {
        $this->updateStackAction->handle($stack->id, [
            'title' => $request['title'],
        ]);

        return redirect()->route('stacks.show', $stack->id);
    }
}
