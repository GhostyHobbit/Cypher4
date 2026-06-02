@php use App\Domain\Entries\Enums\ComponentType; @endphp

<div class="relative"
     x-data="{
        open: false,
        isHoveringComponent: false,
        activeComponentId: null,
        buttonTop: 'auto',

        moveToRow(el, id) {
            this.isHoveringComponent = true;
            this.activeComponentId = id;
            this.buttonTop = el.offsetTop + 'px';
        },
        resetToBottom() {
            this.isHoveringComponent = false;
            this.activeComponentId = null;
            this.buttonTop = 'auto';
        }
     }">

    <div @mouseleave="if ($refs.buttonContainer && !$refs.buttonContainer.contains($event.relatedTarget)) resetToBottom()" class="grid grid-cols-1 gap-y-4 mt-5">
        @foreach($components as $component)
            <div class="relative group/row -ml-12 pl-12"
                 @mouseenter="moveToRow($el, {{ $component->id }})">

                <div class="w-full">
                    @if($editingComponentId === $component->id)
                        @if($component->type === ComponentType::Text->value)
                            @include('entries.partials.edit_text_entry_component')
                        @else
                            @include('entries.partials.image_entry_component', $component)
                        @endif
                    @else
                        @if($component->type === ComponentType::Text->value)
                            <div class="prose max-w-none">{!! $component->text !!}</div>
                        @else
                            @include('entries.partials.image_entry_component', $component)
                        @endif
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    @if($isTextType)
        @include('entries.partials.text_entry_component')
    @endif
    @if($isImageType)
        @include('entries.partials.image_entry_component')
    @endif

    <div x-ref="buttonContainer"
         class="button-container absolute -left-12 inline-flex items-center transition-all duration-150 ease-out pointer-events-none z-20"
         :style="{ top: buttonTop }"
         :class="isHoveringComponent ? '' : 'relative'"
         @mouseleave="resetToBottom()">

        <!-- Main Floating Circle Button -->
        <div class="bg-accent rounded-full cursor-pointer w-8 h-8 p-1 flex items-center justify-center pointer-events-auto text-text-default"
             @click="
                if (isHoveringComponent) {
                    // Check if the current hovered row has an image component wrapper inside it
                    let imgForm = document.getElementById('row-upload-form-' + activeComponentId);
                    if (imgForm) {
                        // If it's an image, click the hidden file input inside it!
                        imgForm.querySelector('input[type=file]').click();
                    } else {
                        // Otherwise, fall back to default text editing mode
                        $wire.editComponent(activeComponentId);
                    }
                } else {
                    open = !open;
                }
             ">
            <template x-if="isHoveringComponent">
                <x-icons.edit class="h-6 w-6 fill-current"/>
            </template>
            <template x-if="!isHoveringComponent">
                <x-icons.plus class="h-6 w-6 fill-current"/>
            </template>
        </div>

        <!-- Plus Button Options Dropdown Menu -->
        <div x-show="open && !isHoveringComponent" x-cloak @click.away="open = false"
             class="absolute left-full -top-12 ml-2 w-40 bg-background-light rounded shadow-lg pointer-events-auto">
            <button wire:click="addComponentForm('text')" @click.prevent="open = false"
                    class="block w-full text-left px-4 py-2 hover:bg-background-dark text-text-default">Text
            </button>
            <label class="block w-full text-left px-4 py-2 hover:bg-background-dark text-text-default cursor-pointer">
                <span>Image</span>
                <input type="file" wire:model.live="newImageFile" class="hidden" accept="image/*">
            </label>
        </div>
    </div>
</div>
