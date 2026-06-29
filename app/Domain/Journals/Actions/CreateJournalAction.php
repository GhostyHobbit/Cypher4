<?php

namespace App\Domain\Journals\Actions;

use App\Domain\Journals\Repositories\JournalRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

readonly class CreateJournalAction
{
    public function __construct(
        private JournalRepository $journalRepository
    ) {}

    public function handle(array $data): RedirectResponse
    {
        $validated = Validator::make($data, $this->rules())->validate();

        $journal = $this->journalRepository->createJournal($validated);

        return redirect(route('journals.show', $journal->id));
    }

    private function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ];
    }
}
