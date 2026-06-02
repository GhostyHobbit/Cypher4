<?php

namespace App\Domain\EntryComponents\Actions;

use App\Domain\Entries\Enums\ComponentType;
use App\Domain\EntryComponents\Repositories\EntryComponentRepository;
use Validator;

class UpdateEntryComponentAction
{
    public function __construct(
        private EntryComponentRepository $entryComponentRepository,
    ) {}

    public function handle(int $entryComponentId, string $componentType, ?string $content): void
    {
        $data = match ($componentType) {
            ComponentType::Text->value => [
                'text' => $content,
            ],
            ComponentType::Image->value => [
                'image_src' => $content,
            ],
        };
        $validated = Validator::make($data, $this->rules($componentType))->validate();
        $this->entryComponentRepository->updateEntryComponent($entryComponentId, $validated);
    }

    private function rules(string $componentType): array
    {
        return [
            'text' => ['required_if:type,'.ComponentType::Text->value, 'string'],
            'image_src' => ['required_if:type,'.ComponentType::Image->value, 'string'],
        ];
    }
}
