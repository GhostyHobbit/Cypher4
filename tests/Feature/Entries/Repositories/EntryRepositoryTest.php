<?php

use App\Domain\Entries\Repositories\EntryRepository;
use App\Models\Entry;
use App\Models\Stack;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    $this->user = User::factory()->create();
    actingAs($this->user);

    $this->repo = app(EntryRepository::class);
});

it('gets all entries', function () {
    Entry::factory()->count(5)->create(['user_id' => $this->user->id]);

    $entries = $this->repo->getEntries();

    assertCount(5, $entries);
});

it('gets entries by id', function () {
    $entry = Entry::factory()->create([
        'user_id' => $this->user->id,
        'title' => 'Title',
    ]);

    $entry = $this->repo->getEntryById($entry->id);

    assertEquals('Title', $entry->title);
});

it('gets entries in a stack', function () {
    $stack = Stack::factory()->create(['user_id' => $this->user->id]);
    Entry::factory()->count(2)->create(['user_id' => $this->user->id]);
    Entry::factory()->count(3)->create([
        'user_id' => $this->user->id,
        'stack_id' => $stack->id,
    ]);

    $entries = $this->repo->getEntriesByStackId($stack->id);

    assertCount(3, $entries);
});

it('gets entries not in a stack', function () {
    $stack = Stack::factory()->create(['user_id' => $this->user->id]);
    Entry::factory()->count(2)->create(['user_id' => $this->user->id]);
    Entry::factory()->count(3)->create([
        'user_id' => $this->user->id,
        'stack_id' => $stack->id,
    ]);

    $entries = $this->repo->getStacklessEntries();

    assertCount(2, $entries);
});

it('creates an entry', function () {
    $entry = $this->repo->createEntry([
        'user_id' => $this->user->id,
        'title' => 'Title',
        'stack_id' => null,
    ]);

    assertDatabaseHas('entries', [
        'id' => $entry->id,
        'title' => $entry->title,
    ]);
});

it('updates an entry', function () {
    $stack = Stack::factory()->create(['user_id' => $this->user->id]);
    $entry = Entry::factory()->create([
        'user_id' => $this->user->id,
        'title' => 'Title',
        'stack_id' => null,
    ]);

    $this->repo->updateEntry($entry->id, [
        'title' => 'New Title',
        'stack_id' => $stack->id,
    ]);

    assertDatabaseHas('entries', [
        'id' => $entry->id,
        'title' => 'New Title',
        'stack_id' => $stack->id,
    ]);
});

it('deletes an entry', function () {
    $entry = Entry::factory()->create([
        'user_id' => $this->user->id,
        'title' => 'Title',
    ]);

    $this->repo->deleteEntry($entry->id);

    assertDatabaseMissing('entries', [
        'id' => $entry->id,
        'title' => $entry->title,
    ]);
});
