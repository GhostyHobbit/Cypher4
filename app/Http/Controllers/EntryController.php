<?php

namespace App\Http\Controllers;

use App\Domain\Entries\Actions\CreateEntryAction;
use App\Domain\Entries\Actions\UpdateEntryAction;
use App\Domain\Entries\Repositories\EntryRepository;
use App\Models\Entry;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EntryController extends Controller
{
    public function __construct(
        private readonly EntryRepository $entryRepository,
        private readonly CreateEntryAction $createEntryAction,
        private readonly UpdateEntryAction $updateEntryAction,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('entries.index')->with([
            'entries' => $this->entryRepository->getEntries(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->createEntryAction->handle([
            'title' => $request['title'],
            'stack_id' => $request['stack_id'],
            'user_id' => Auth::user()->id,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Entry $entry): View
    {
        return view('entries.edit')->with([
            'entry' => $entry,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Entry $entry): RedirectResponse
    {
        $this->updateEntryAction->handle($entry->id, [
            'title' => $request['title'],
            'stack_id' => $request['stack_id'],
        ]);

        return redirect()->route('entries.edit', $entry->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entry $entry): RedirectResponse
    {
        $stackId = $entry->stack_id;
        $this->entryRepository->deleteEntry($entry->id);

        return ! is_null($stackId) ? redirect()->route('stacks.show', $stackId) : redirect()->route('home');
    }
}
