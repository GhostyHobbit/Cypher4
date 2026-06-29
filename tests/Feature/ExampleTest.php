<?php

use App\Models\User;

use function Pest\Laravel\actingAs;

it('returns a successful response', function () {
    $user = User::factory()->create();
    actingAs($user);
    $response = $this->get('/dashboard');

    $response->assertStatus(200);
});
