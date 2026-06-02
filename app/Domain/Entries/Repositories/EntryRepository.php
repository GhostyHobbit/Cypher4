<?php

namespace App\Domain\Entries\Repositories;

use App\Models\Entry;
use Auth;
use Illuminate\Support\Collection;

class EntryRepository
{
    public function getEntries(): Collection
    {
        return !is_null(Auth::user()) ? Entry::where('user_id', Auth::user()->id)
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
            ->orderBy('title')
            ->get();
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
        ]);
    }
}
