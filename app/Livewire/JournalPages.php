<?php

namespace App\Livewire;

use App\Domain\Journals\Repositories\JournalRepository;
use App\Domain\Pages\Actions\EditPageAction;
use App\Domain\Pages\Repositories\PageRepository;
use App\Models\Journal;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class JournalPages extends Component
{
    protected JournalRepository $journalRepository;

    protected PageRepository $pageRepository;

    protected EditPageAction $editPageAction;

    public bool $hasPages = false;

    public bool $isEditing = false; // Flag to toggle view modes cleanly

    public int $journalId;

    public int $pageCount = 0;

    public int $currentPage = 1;

    public Journal $journal;

    public string $content = '';

    public function boot(
        JournalRepository $journalRepository,
        PageRepository $pageRepository,
        EditPageAction $editPageAction
    ): void {
        $this->journalRepository = $journalRepository;
        $this->pageRepository = $pageRepository;
        $this->editPageAction = $editPageAction;
    }

    public function mount(): void
    {
        $this->journal = $this->journalRepository->getJournalById($this->journalId);
        $this->currentPage = 1;
        $this->refreshJournalState();
        $this->loadPageContent(); // Seed initial values exclusively on initialization steps
    }

    private function refreshJournalState(): void
    {
        $this->pageCount = $this->pageRepository->getJournalPagesCount($this->journalId);
        $this->hasPages = $this->pageCount > 0;
    }

    private function loadPageContent(): void
    {
        if ($this->hasPages) {
            $page = $this->pageRepository->getPageByOrder($this->journalId, $this->currentPage);
            if ($page && ! is_null($page->content)) {
                $this->content = $page->content;
            } else {
                $this->content = '';
            }
        } else {
            $this->content = '';
        }
    }

    public function nextPage(): void
    {
        if ($this->currentPage < $this->pageCount) {
            $this->currentPage++;
            $this->isEditing = false; // Reset view visibility boundaries on navigation
            $this->loadPageContent();
        }
    }

    public function previousPage(): void
    {
        if ($this->currentPage > 1) {
            $this->currentPage--;
            $this->isEditing = false;
            $this->loadPageContent();
        }
    }

    #[On('page-added')]
    public function onPageCreated(): void
    {
        $this->refreshJournalState();
        $this->currentPage = $this->pageCount;
        $this->loadPageContent();
    }

    public function savePageContent(int $pageId): void
    {
        $this->editPageAction->handle($pageId, ['content' => $this->content]);
    }

    public function deletePage(int $pageId): void
    {
        $this->pageRepository->deletePage($pageId);
        $this->refreshJournalState();
        $this->loadPageContent();
    }

    public function render(): View
    {
        // Simply pull data dynamically without modifying the component state properties during render loops!
        $currentPageContent = $this->hasPages
            ? $this->pageRepository->getPageByOrder($this->journalId, $this->currentPage)
            : null;

        return view('livewire.journal-pages')->with([
            'journal' => $this->journal,
            'pageContent' => $currentPageContent,
        ]);
    }
}
