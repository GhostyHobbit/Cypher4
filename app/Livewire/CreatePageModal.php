<?php

namespace App\Livewire;

use App\Domain\Pages\Repositories\PageRepository;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class CreatePageModal extends Component
{
    protected PageRepository $pageRepository;

    public bool $isOpen = false;

    public int $journalId;

    public string $subject = '';

    public string $content = '';

    public function boot(
        PageRepository $pageRepository
    ): void {
        $this->pageRepository = $pageRepository;
    }

    #[On('open-create-page-modal')]
    public function openModal(int $journalId): void
    {
        $this->journalId = $journalId;
        $this->isOpen = true;

        $this->reset(['subject', 'content']);
    }

    public function save(): void
    {
        $this->validate([
            'subject' => ['required', 'string'],
        ]);

        $this->pageRepository->createPage([
            'journal_id' => $this->journalId,
            'subject' => $this->subject,
        ]);

        $this->isOpen = false;

        $this->dispatch('page-added');
    }

    public function render(): View
    {
        return view('livewire.create-page-modal');
    }
}
