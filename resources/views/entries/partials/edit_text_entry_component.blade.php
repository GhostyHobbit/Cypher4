@php use App\Domain\Entries\Enums\ComponentType; @endphp

<div class="w-full"
     wire:ignore
     wire:key="editor-component-{{ $this->id ?? uniqid() }}"
     x-data="{
        content: @entangle('text'),
        editor: null,

        init() {
            this.$nextTick(() => {
                try {
                    this.editor = new window.TipTapEditor({
                        element: this.$refs.editorContainer,
                        content: this.content,
                        extensions: [
                            window.TipTapStarterKit.configure({
                                heading: false,
                            }),
                            window.TipTapHeading.configure({
                                levels: [1, 2, 3]
                            }),
                        ],
                        onUpdate: ({ editor }) => {
                            this.content = editor.getHTML();
                        },
                        onCreate: ({ editor }) => {
                            editor.commands.focus('end');
                        },
                        onBlur: ({ event }) => {
                            const toolbar = this.$el.querySelector('.flex.gap-2.p-2');
                            if (event?.relatedTarget && toolbar && toolbar.contains(event.relatedTarget)) {
                                return;
                            }
                            if (event?.relatedTarget && event.relatedTarget.classList.contains('editor-menu-item')) {
                                return;
                            }
                            $wire.saveComponent();
                        }
                    });
                    this.$watch('content', value => {
                        if (this.editor && value !== this.editor.getHTML() && value !== undefined) {
                            Alpine.raw(this.editor).commands.setContent(value, false);
                        }
                    });
                } catch (error) {
                    console.error('TipTap setup failed:', error);
                }
            });
        }
     }">

    <form wire:submit.prevent="saveComponent">
        <div class="mb-4">
            <div class="flex gap-2 p-2 border border-b-0 border-accent rounded-t-md bg-background-dark">
                <button type="button" tabindex="-1" @click="Alpine.raw(editor).chain().focus().toggleHeading({ level: 1 }).run()" :class="{ 'text-text-default': Alpine.raw(editor)?.isActive('heading', { level: 1 }) }" class="px-2 py-1 text-sm hover:bg-background-light rounded transition">
                    H1
                </button>
                <button type="button" tabindex="-1" @click="Alpine.raw(editor).chain().focus().toggleHeading({ level: 2 }).run()" :class="{ 'text-text-default': Alpine.raw(editor)?.isActive('heading', { level: 2 }) }" class="px-2 py-1 text-sm hover:bg-background-light rounded transition">
                    H2
                </button>
                <button type="button" tabindex="-1" @click="Alpine.raw(editor).chain().focus().toggleHeading({ level: 3 }).run()" :class="{ 'text-text-default': Alpine.raw(editor)?.isActive('heading', { level: 2 }) }" class="px-2 py-1 text-sm hover:bg-background-light rounded transition">
                    H3
                </button>
                <button type="button" tabindex="-1" @click="Alpine.raw(editor).chain().focus().setParagraph().run()" :class="{ 'text-text-default': Alpine.raw(editor)?.isActive('heading', { level: 2 }) }" class="px-2 py-1 text-sm hover:bg-background-light rounded transition">
                    P
                </button>
                <div class="h-8 w-[1px] bg-accent mx-1"></div>

                <button type="button" tabindex="-1" @click="Alpine.raw(editor).chain().focus().toggleBold().run()" :class="{ 'text-text-default font-bold': Alpine.raw(editor)?.isActive('bold') }" class="px-2 py-1 text-sm hover:bg-background-light rounded transition">
                    B
                </button>
                <button type="button" tabindex="-1" @click="Alpine.raw(editor).chain().focus().toggleItalic().run()" :class="{ 'text-text-default italic': Alpine.raw(editor)?.isActive('italic') }" class="px-2 py-1 text-sm hover:bg-background-light rounded transition">
                    <div class="italic">I</div>
                </button>
                <button type="button" tabindex="-1" @click="Alpine.raw(editor).chain().focus().toggleUnderline().run()" :class="{ 'text-text-default': Alpine.raw(editor)?.isActive('bold') }" class="px-2 py-1 text-sm hover:bg-background-light rounded transition">
                    <div class="text-decoration-line: underline">U</div>
                </button>
                <button type="button" tabindex="-1" @click="Alpine.raw(editor).chain().focus().toggleStrike().run()" :class="{ 'text-text-default': Alpine.raw(editor)?.isActive('bold') }" class="px-2 py-1 text-sm hover:bg-background-light rounded transition">
                    <div class="text-decoration-line: line-through">S</div>
                </button>
                <div class="h-8 w-[1px] bg-accent mx-1"></div>
                <button type="button" tabindex="-1" @click="Alpine.raw(editor).chain().focus().toggleBulletList().run()" :class="{ 'text-text-default': Alpine.raw(editor)?.isActive('bulletList') }" class="px-2 py-1 text-sm hover:bg-background-light rounded flex items-center gap-1">
                    <x-icons.list-ul class="h-5 w-5 fill-text-default"/>
                </button>
                <button type="button" tabindex="-1" @click="Alpine.raw(editor).chain().focus().toggleOrderedList().run()" :class="{ 'text-text-default': Alpine.raw(editor)?.isActive('bulletList') }" class="px-2 py-1 text-sm hover:bg-background-light rounded flex items-center gap-1">
                    <x-icons.list-ol class="h-5 w-5 fill-text-default"/>
                </button>
            </div>

            <div x-ref="editorContainer"
                 style="--tw-prose-body: 'var(--color-text-default)'; --tw-prose-headings: 'var(--color-text-default)';"
                 class="prose dark:prose-invert max-w-none w-full p-4 border border-accent rounded-b-md bg-background-light min-h-[150px] focus:outline-none focus:border-none focus:ring-0"></div>

            <x-input-error :messages="$errors->get('text')" class="mt-2"/>
        </div>

        <div class="inline-flex rounded-md shadow-sm" x-data="{ menuOpen: false }">
            <button type="submit" class="inline-flex items-center gap-2 rounded-l-md bg-accent_purple px-3 py-2 text-sm font-semibold text-text-default hover:bg-accent-dark border-r border-background-dark">
                <x-icons.floppy-disk class="h-6 w-6 fill-text-default"/>
                Save Changes
            </button>

            <div class="relative inline-flex">
                <button type="button" @click="menuOpen = !menuOpen" tabindex="-1" class="editor-menu-item inline-flex items-center rounded-r-md bg-accent_purple px-2 py-2 text-text-default hover:bg-accent-dark">
                    <x-icons.ellipsis class="h-6 w-6 rotate-90 fill-text-default"/>
                </button>

                <div x-show="menuOpen" x-cloak @click.away="menuOpen = false"
                     class="absolute left-11 -top-2 mt-2 w-40 origin-top-right rounded-md bg-background-light shadow-lg ring-1 ring-black ring-opacity-5 z-30">
                    <div class="py-1">
                        <button type="button" wire:click="deleteComponent" @click="menuOpen = false" tabindex="-1" class="editor-menu-item flex w-full items-center gap-2 px-4 py-2 text-left text-sm text-red-600 hover:bg-background-dark">
                            <x-icons.trash class="h-4 w-4 fill-current"/> Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
