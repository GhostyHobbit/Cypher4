<?php

namespace App\Domain\Entries\Actions;

use App\Domain\Entries\Repositories\EntryRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

readonly class CreateEntryAction
{
    public function __construct(
        private EntryRepository $entryRepository
    ) {}

    public function handle(array $data): RedirectResponse
    {
        $validated = Validator::make($data, $this->rules())->validate();

        $entry = $this->entryRepository->createEntry($validated);

        return redirect()->route('entries.edit', $entry->id);
    }

    private function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'stack_id' => ['nullable', 'integer'],
            'user_id' => ['required', 'integer'],
        ];
    }
}
