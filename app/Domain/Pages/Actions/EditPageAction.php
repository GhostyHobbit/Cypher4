<?php

namespace App\Domain\Pages\Actions;

use App\Domain\Pages\Repositories\PageRepository;
use Illuminate\Support\Facades\Validator;

readonly class EditPageAction
{
    public function __construct(
        private PageRepository $pageRepository,
    ) {}

    public function handle(int $pageId, array $content): void
    {
        $validated = Validator::make($content, $this->rules())->validate();

        $this->pageRepository->updatePage($pageId, $validated);
    }

    private function rules(): array
    {
        return [
            'content' => 'required|string',
        ];
    }
}
