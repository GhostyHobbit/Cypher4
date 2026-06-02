<?php

namespace App\Domain\EntryComponents\Repositories;

use App\Models\Entry;
use App\Models\EntryComponent;
use Illuminate\Support\Collection;

class EntryComponentRepository
{
    public function getEntryComponents(): Collection
    {
        return EntryComponent::all();
    }

    public function getPageComponents(int $entryId): Collection
    {
        return EntryComponent::query()->where('entry_id', $entryId)->get();
    }

    public function getEntryComponentById(int $entryComponentId): EntryComponent
    {
        return EntryComponent::findOrFail($entryComponentId);
    }

    public function saveEntryComponent(int $entryId, array $validated): EntryComponent
    {
        $entry = Entry::findOrFail($entryId);

        $component = new EntryComponent([
            'type' => $validated['type'],
            'text' => $validated['text'] ?? null,
            'image_src' => $validated['image_src'] ?? null,
        ]);

        $component->entry()->associate($entry);
        $component->save();

        return $component;
    }

    public function updateEntryComponent(int $entryComponentId, array $validated): void
    {
        $entryComponent = $this->getEntryComponentById($entryComponentId);

        $entryComponent->update([
            'text' => $validated['text'] ?? null,
            'image_src' => $validated['image_src'] ?? null,
        ]);
    }

    public function deleteEntryComponent(int $entryComponentId): void
    {
        $entryComponent = $this->getEntryComponentById($entryComponentId);
        $entryComponent->delete();
    }
}
