<x-app-layout>
    <p>{{ $entry->title }}</p>
    <p>{{ $entry->body }}</p>
    <x-link-button href="{{ route('entries.edit', $entry->id) }}">Edit entry</x-link-button>
    <x-link-button href="{{ route('entries.index') }}" :cat="false">Back to overview</x-link-button>
</x-app-layout>
