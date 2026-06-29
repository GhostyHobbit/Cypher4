<?php

namespace App\Domain\Entries\Repositories;

use App\Domain\EntryComponents\Repositories\EntryComponentRepository;
use App\Models\Entry;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class EntryRepository
{
    public function __construct(
        private EntryComponentRepository $entryComponentRepository,
    ) {}

    public function getEntries(): Collection
    {
        return ! is_null(Auth::user()) ? Entry::where('user_id', Auth::user()->id)
            ->orderBy('title')
            ->get() : Entry::all();
    }

    public function getEntryById(int $entryId): Entry
    {
        return Entry::findOrFail($entryId);
    }

    public function getEntriesByStackId(int $stackId): Collection
    {
        return Entry::query()
            ->where('stack_id', $stackId)
            ->where('user_id', Auth::user()->id)
//            ->orderBy('title')
            ->get();
    }

    public function getStackEntriesCount(int $stackId): int
    {
        return Entry::query()
            ->where('stack_id', $stackId)
            ->where('user_id', Auth::user()->id)
            ->count();
    }

    public function getStacklessEntries(): Collection
    {
        return Entry::query()
            ->where('user_id', Auth::user()->id)
            ->where('stack_id', null)
            ->orderBy('title')
            ->get();
    }

    public function createEntry(array $validated): Entry
    {
        return Entry::create([
            'title' => $validated['title'],
            'stack_id' => $validated['stack_id'],
            'user_id' => $validated['user_id'],
        ]);
    }

    public function updateEntry(int $entryId, array $validated): void
    {
        $entry = $this->getEntryById($entryId);

        $entry->update([
            'title' => $validated['title'],
            'stack_id' => $validated['stack_id'],
        ]);
    }

    public function deleteEntry(int $entryId): void
    {
        $entry = $this->getEntryById($entryId);
        $components = $this->entryComponentRepository->getPageComponents($entry->id);
        foreach ($components as $component) {
            $this->entryComponentRepository->deleteEntryComponent($component->id);
        }
        $entry->delete();
    }
}
