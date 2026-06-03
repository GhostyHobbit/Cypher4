<?php

namespace App\Livewire;

use App\Domain\Entries\Enums\ComponentType;
use App\Domain\EntryComponents\Actions\CreateEntryComponentAction;
use App\Domain\EntryComponents\Actions\UpdateEntryComponentAction;
use App\Domain\EntryComponents\Repositories\EntryComponentRepository;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class EntryEditor extends Component
{
    use WithFileUploads;

    public bool $isTextType = false;

    public bool $isImageType = false;

    public $newImageFile;

    public ?string $text = null;

    public ?string $image_src = null;

    public int $entryId;

    public ?int $editingComponentId = null;

    public function addComponentForm(string $type): void
    {
        $this->isTextType = false;
        $this->isImageType = false;

        $type = ComponentType::tryFrom($type);

        match ($type) {
            ComponentType::Text => $this->isTextType = true,
            ComponentType::Image => $this->isImageType = true,
            default => null,
        };

        $this->dispatch('component-form-opened');
        $this->resetErrorBag();
    }

    public function saveComponent(CreateEntryComponentAction $createEntryComponentAction): void
    {
        if (! is_null($this->editingComponentId)) {
            $this->updateComponent();

            return;
        }

        $type = ComponentType::Text;
        if ($this->isImageType) {
            $this->updateComponent();

            return;
        }

        $createEntryComponentAction->handle($this->entryId, $type, $this->text);

        $this->reset('text', 'image_src', 'isTextType', 'isImageType');
    }

    public function editComponent(int $componentId): void
    {
        $this->editingComponentId = $componentId;

        $component = app(EntryComponentRepository::class)->getEntryComponentById($componentId);
        $this->text = $component->text ?? '';
        $this->image_src = $component->image_src ?? '';
    }

    public function updateComponent(): void
    {
        $component = app(EntryComponentRepository::class)->getEntryComponentById($this->editingComponentId);

        app(UpdateEntryComponentAction::class)->handle($component->id, $component->type, $this->text);

        $this->reset('editingComponentId', 'text', 'image_src', 'isTextType', 'isImageType');
    }

    public function cancelEdit(): void
    {
        $this->resetErrorBag();
        $this->reset(['editingComponentId', 'text', 'image_src']);
    }

    public function deleteComponent(?int $id): void
    {
        if (is_null($id) && is_null($this->editingComponentId)) {
            $this->reset('editingComponentId', 'text', 'image_src', 'isTextType', 'isImageType');

            return;
        }

        app(EntryComponentRepository::class)->deleteEntryComponent($id ?? $this->editingComponentId);

        $this->reset('editingComponentId', 'text', 'image_src', 'isTextType', 'isImageType');
    }

    public function updatedNewImageFile(): void
    {
        $this->validate(['newImageFile' => 'image|max:2048']);
        $path = $this->newImageFile->store('entry-component-photos', 'public');
        $type = ComponentType::Image;

        app(CreateEntryComponentAction::class)->handle($this->entryId, $type, $path);

        $this->reset(['newImageFile', 'isImageType']);
    }

    public function render(): View
    {
        $components = app(EntryComponentRepository::class)->getPageComponents($this->entryId);

        return view('livewire.entry-editor')->with(compact('components'));
    }
}
