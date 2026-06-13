<?php

namespace App\Domain\Journals\Repositories;

use App\Domain\Pages\Repositories\PageRepository;
use App\Models\Journal;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class JournalRepository
{
    public function __construct(
        private PageRepository $pageRepository,
    ) {}

    public function getAllJournals(): Collection
    {
        return Journal::all();
    }

    public function getUserJournals(): Collection
    {
        return Journal::query()->where('user_id', Auth::user()->id)->get();
    }

    public function getJournalById(int $journalId): Journal
    {
        return Journal::query()->findOrFail($journalId);
    }

    public function createJournal(array $validated): Journal
    {
        return Journal::query()->create([
            'title' => $validated['title'],
            'user_id' => $validated['user_id'],
        ]);
    }

    public function updateJournal(int $journalId, array $validated): void
    {
        $journal = $this->getJournalById($journalId);

        $journal->update([
            'title' => $validated['title'],
        ]);
    }

    public function deleteJournal(int $journalId): void
    {
        $journal = $this->getJournalById($journalId);

        $pages = $this->pageRepository->getJournalPages($journalId);

        foreach ($pages as $page) {
            $this->pageRepository->deletePage($page->id);
        }
        $journal->delete();
    }
}
