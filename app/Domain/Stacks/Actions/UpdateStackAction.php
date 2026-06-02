<?php

namespace App\Domain\Stacks\Actions;

use App\Domain\Stacks\Repositories\StackRepository;
use Illuminate\Support\Facades\Validator;

readonly class UpdateStackAction
{
    public function __construct(
        private StackRepository $stackRepository,
    ) {}

    public function handle(int $stackId, array $data): void
    {
        $validated = Validator::make($data, $this->rules())->validate();

        $this->stackRepository->updateStack($stackId, $validated);
    }

    private function rules(): array
    {
        return [
            'title' => ['required', 'string'],
        ];
    }
}
