<?php

namespace App\Domain\Pages\Repositories;

use App\Models\Page;
use Illuminate\Support\Collection;

class PageRepository
{
    public function getJournalPages(int $journalId): Collection
    {
        return Page::query()->where('journal_id', $journalId)->get();
    }

    public function getPageByOrder(int $journalId, int $pageIndex): Page
    {
        return Page::query()->where('journal_id', $journalId)
            ->orderBy('created_at', 'asc')
            ->skip($pageIndex - 1)
            ->first();
    }

    public function getJournalPagesCount(int $journalId): int
    {
        return Page::query()->where('journal_id', $journalId)->count();
    }

    public function getPageById(int $pageId): Page
    {
        return Page::query()->findOrFail($pageId);
    }

    public function createPage(array $validated): Page
    {
        return Page::query()->create([
            'subject' => $validated['subject'],
            'content' => null,
            'journal_id' => $validated['journal_id'],
        ]);
    }

    public function updatePage(int $pageId, array $validated): void
    {
        $page = $this->getPageById($pageId);

        $page->update([
            'content' => $validated['content'],
        ]);
    }

    public function deletePage(int $pageId): void
    {
        $page = $this->getPageById($pageId);
        $page->delete();
    }
}
