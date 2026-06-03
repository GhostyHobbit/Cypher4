<?php

namespace App\Domain\Entries\Actions;

use App\Domain\Entries\Repositories\EntryRepository;
use Illuminate\Support\Facades\Validator;

readonly class UpdateEntryAction
{
    public function __construct(
        private EntryRepository $entryRepository
    ) {}

    public function handle(int $entryId, array $data): void
    {
        $validated = Validator::make($data, $this->rules())->validate();

        $this->entryRepository->updateEntry($entryId, $validated);
    }

    private function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'stack_id' => ['nullable', 'integer'],
        ];
    }
}
