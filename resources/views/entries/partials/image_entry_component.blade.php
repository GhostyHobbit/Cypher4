@php use App\Domain\Entries\Enums\ComponentType; @endphp

<div class="relative w-full group my-2">

    <!-- Clean Image Display Frame -->
    <div class="relative w-full h-[50vh] rounded-lg overflow-hidden bg-background-dark">
        <img src="{{ !empty($component->image_src) ? asset('storage/' . $component->image_src) : asset('images/apollopfp.jpg') }}" alt="entry image asset" class="w-full h-full object-cover"/>
        <div class="absolute top-3 right-3 flex items-center gap-2 group">
            <button type="button" @click.prevent.stop="" wire:click="deleteComponent({{ $component->id }})"
                    class="group-hover:bg-accent_purple text-text-default rounded-md p-2 shadow-lg flex items-center justify-center"
                    title="Delete Image Block">
                <x-icons.trash class="h-4 w-4 fill-transparent group-hover:fill-text-default"/>
            </button>
        </div>
    </div>

    <!-- Hidden Native Form (Given a unique dynamic ID so the hover button can find it) -->
    <form id="row-upload-form-{{ $component->id }}"
          action="{{ route('photo.upload', ['type' => 'entry_component', 'id' => $component->id]) }}"
          method="POST"
          enctype="multipart/form-data"
          class="hidden">
        @csrf
        <input type="file"
               name="photo"
               @change="$el.form.submit()"
               accept="image/*">
    </form>

    @error('photo')
    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
    @enderror
</div>
