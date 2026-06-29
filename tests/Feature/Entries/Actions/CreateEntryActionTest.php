<?php

use App\Domain\Entries\Actions\CreateEntryAction;
use App\Models\Stack;
use App\Models\User;
use Illuminate\Validation\ValidationException;

it('creates an entry successfully', function ($stackIdValue) {
    $user = User::factory()->create();
    $stack = $stackIdValue === 'has_stack'
        ? Stack::factory()->create(['user_id' => $user->id])
        : null;

    $data = [
        'title' => 'My Awesome Entry',
        'user_id' => $user->id,
        'stack_id' => $stack?->id,
    ];

    $action = app(CreateEntryAction::class);
    $response = $action->handle($data);

    $this->assertDatabaseHas('entries', [
        'title' => 'My Awesome Entry',
        'user_id' => $user->id,
        'stack_id' => $stack?->id,
    ]);

    expect($response->getStatusCode())->toBe(302)
        ->and($response->getTargetUrl())->toContain(route('entries.edit', ['entry' => 1]));

})->with([
    'with a stack ID' => ['has_stack'],
    'without a stack ID' => [null],
]);

it('fails validation when required fields are missing', function () {
    $action = app(CreateEntryAction::class);

    expect(fn () => $action->handle([]))
        ->toThrow(ValidationException::class);
});
