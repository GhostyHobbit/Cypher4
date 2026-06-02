<?php

namespace App\Domain\Stacks\Actions;

use App\Domain\Stacks\Repositories\StackRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

readonly class CreateStackAction
{
    public function __construct(
        private StackRepository $stackRepository,
    ){}

    public function handle(array $data): RedirectResponse
    {
        $validated = Validator::make($data, $this->rules())->validate();

        $stack = $this->stackRepository->createStack($validated);

        return redirect()->route('stacks.show', $stack->id);
    }

    private function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'user_id' => ['required', 'integer'],
        ];
    }
}
