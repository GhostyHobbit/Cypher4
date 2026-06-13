<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Models\EntryComponent;
use App\Models\Journal;
use App\Models\Stack;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    protected array $map = [
        'user' => [User::class, 'image_src', 'profile-photos'],
        'entry' => [Entry::class, 'cover_image', 'entry-photos'],
        'stack' => [Stack::class, 'cover_image', 'stack-photos'],
        'journal' => [Journal::class, 'cover_image', 'journal-photos'],
        'entry_component' => [EntryComponent::class, 'image_src', 'entry-component-photos'],
    ];

    public function update(Request $request, string $type, string $id)
    {
        if (! array_key_exists($type, $this->map)) {
            abort(400, 'Invalid upload type.');
        }

        [$modelClass, $column, $directory] = $this->map[$type];

        $model = $modelClass::findOrFail($id);

        if (method_exists($model, 'user_id') && $model->user_id !== auth()->id() && $type !== 'user') {
            abort(403);
        }

        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($model->{$column}) {
            Storage::disk('public')->delete($model->{$column});
        }

        $path = $request->file('photo')->store($directory, 'public');

        $model->update([
            $column => $path,
        ]);

        return back()->with('status', "{$type}-photo-updated");
    }
}
