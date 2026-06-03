<?php

namespace App\Domain\Stacks\Repositories;

use App\Models\Stack;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class StackRepository
{
    public function getStacks(): Collection
    {
        return ! is_null(Auth::user()) ? Stack::where('user_id', Auth::user()->id)
            ->orderBy('title')
            ->get() : Stack::all();
    }

    public function getStackById(int $stackId): Stack
    {
        return Stack::findOrFail($stackId);
    }

    public function createStack(array $validated): Stack
    {
        return Stack::create([
            'title' => $validated['title'],
            'user_id' => $validated['user_id'],
        ]);
    }

    public function updateStack(int $stackId, array $validated): void
    {
        $stack = $this->getStackById($stackId);

        $stack->update([
            'title' => $validated['title'],
        ]);
    }
}
