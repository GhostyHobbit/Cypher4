<div class="w-full mt-4"
     wire:ignore
     wire:key="journal-editor-{{ $pageContent->id }}"
     x-data="{
        content: @entangle('content'),
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
                        onBlur: ({ editor }) => {
                            // AUTOSAVE: Triggers when clicking away from the editor
                            @this.savePageContent({{ $pageContent->id }}).then(() => {
                                @this.set('isEditing', false);
                            });
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

    <form wire:submit.prevent="savePageContent({{ $pageContent->id }}).then(() => { @this.set('isEditing', false); })">
        <div class="mb-4">
            {{-- TOOLBAR CONTAINER --}}
            <div class="flex gap-2 p-2 border border-b-0 border-accent rounded-t-md bg-background-dark">
                <button type="button" tabindex="-1" @click="Alpine.raw(editor).chain().focus().toggleHeading({ level: 1 }).run()" :class="{ 'text-text-default': Alpine.raw(editor)?.isActive('heading', { level: 1 }) }" class="px-2 py-1 text-sm hover:bg-background-light rounded transition">H1</button>
                <button type="button" tabindex="-1" @click="Alpine.raw(editor).chain().focus().toggleHeading({ level: 2 }).run()" :class="{ 'text-text-default': Alpine.raw(editor)?.isActive('heading', { level: 2 }) }" class="px-2 py-1 text-sm hover:bg-background-light rounded transition">H2</button>
                <button type="button" tabindex="-1" @click="Alpine.raw(editor).chain().focus().toggleHeading({ level: 3 }).run()" :class="{ 'text-text-default': Alpine.raw(editor)?.isActive('heading', { level: 3 }) }" class="px-2 py-1 text-sm hover:bg-background-light rounded transition">H3</button>
                <button type="button" tabindex="-1" @click="Alpine.raw(editor).chain().focus().setParagraph().run()" :class="{ 'text-text-default': Alpine.raw(editor)?.isActive('paragraph') }" class="px-2 py-1 text-sm hover:bg-background-light rounded transition">P</button>

                <div class="h-8 w-[1px] bg-accent mx-1"></div>

                <button type="button" tabindex="-1" @click="Alpine.raw(editor).chain().focus().toggleBold().run()" :class="{ 'text-text-default font-bold': Alpine.raw(editor)?.isActive('bold') }" class="px-2 py-1 text-sm hover:bg-background-light rounded transition">B</button>
                <button type="button" tabindex="-1" @click="Alpine.raw(editor).chain().focus().toggleItalic().run()" :class="{ 'text-text-default italic': Alpine.raw(editor)?.isActive('italic') }" class="px-2 py-1 text-sm hover:bg-background-light rounded transition"><span class="italic">I</span></button>

                <div class="h-8 w-[1px] bg-accent mx-1"></div>

                <button type="button" tabindex="-1" @click="Alpine.raw(editor).chain().focus().toggleBulletList().run()" :class="{ 'text-text-default': Alpine.raw(editor)?.isActive('bulletList') }" class="px-2 py-1 text-sm hover:bg-background-light rounded flex items-center gap-1">
                    <x-icons.list-ul class="h-5 w-5 fill-text-default"/>
                </button>
                <button type="button" tabindex="-1" @click="Alpine.raw(editor).chain().focus().toggleOrderedList().run()" :class="{ 'text-text-default': Alpine.raw(editor)?.isActive('orderedList') }" class="px-2 py-1 text-sm hover:bg-background-light rounded flex items-center gap-1">
                    <x-icons.list-ol class="h-5 w-5 fill-text-default"/>
                </button>
            </div>

            {{-- TEXT EDITOR CANVAS AREA --}}
            <div x-ref="editorContainer"
                 style="--tw-prose-body: 'var(--color-text-default)'; --tw-prose-headings: 'var(--color-text-default)';"
                 class="prose dark:prose-invert max-w-none w-full p-4 border border-accent rounded-b-md bg-background-light min-h-32 focus:outline-none focus:border-none focus:ring-0"></div>

            <x-input-error :messages="$errors->get('content')" class="mt-2"/>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="inline-flex items-center gap-2 rounded-md bg-accent_purple px-4 py-2 text-sm font-semibold text-text-default hover:bg-accent-dark transition shadow-sm">
                <x-icons.floppy-disk class="h-5 w-5 fill-text-default"/>
                Save Page
            </button>

            <button type="button" wire:click="$set('isEditing', false)" class="inline-flex items-center gap-2 rounded-md bg-background-dark px-4 py-2 text-sm font-semibold text-text-default">
                Cancel
            </button>
        </div>
    </form>
</div>
