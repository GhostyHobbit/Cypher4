<?php

namespace App\Domain\Stacks\Actions;

use App\Domain\Entries\Repositories\EntryRepository;
use App\Domain\Stacks\Repositories\StackRepository;

readonly class DeleteStackAction
{
    public function __construct(
        private StackRepository $stackRepository,
        private EntryRepository $entryRepository,
    ) {}

    public function handle(int $stackId, bool $hasEntries): void
    {
        if ($hasEntries) {
            $entries = $this->entryRepository->getEntriesByStackId($stackId);

            foreach ($entries as $entry) {
                $this->entryRepository->deleteEntry($entry->id);
            }
        }

        $this->stackRepository->deleteStack($stackId);
    }
}
