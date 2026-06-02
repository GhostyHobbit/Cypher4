<?php

namespace App\Domain\EntryComponents\Actions;

use App\Domain\Entries\Enums\ComponentType;
use App\Domain\EntryComponents\Repositories\EntryComponentRepository;
use Validator;

class CreateEntryComponentAction
{
    public function __construct(
        private EntryComponentRepository $entryComponentRepository,
    ) {}

    public function handle(int $entryId, ComponentType $componentType, ?string $content): void
    {
        $data = match ($componentType) {
            ComponentType::Text => [
                'type' => ComponentType::Text->value,
                'text' => $content,
            ],
            ComponentType::Image => [
                'type' => ComponentType::Image->value,
                'image_src' => $content,
            ],
        };

        $validated = Validator::make($data, $this->rules($componentType))->validate();

        $this->entryComponentRepository->saveEntryComponent($entryId, $validated);
    }

    private function rules(ComponentType $componentType): array
    {
        return [
            'type' => ['required', 'string'],
            'text' => ['required_if:type,'.ComponentType::Text->value, 'string'],
            'image_src' => ['required_if:type,'.ComponentType::Image->value, 'string'],
        ];
    }
}
