<?php

namespace App\Http\Controllers;

use App\Domain\Journals\Actions\CreateJournalAction;
use App\Domain\Journals\Repositories\JournalRepository;
use App\Models\Journal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class JournalController extends Controller
{
    public function __construct(
        private CreateJournalAction $createJournalAction,
        private JournalRepository $journalRepository,
    ) {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->createJournalAction->handle([
            'title' => $request['title'],
            'user_id' => Auth::user()->id,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Journal $journal): View
    {
        return view('journals.show')->with([
            'journal' => $journal,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Journal $journal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Journal $journal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Journal $journal): RedirectResponse
    {
        $this->journalRepository->deleteJournal($journal->id);

        return redirect()->route('home');
    }
}
