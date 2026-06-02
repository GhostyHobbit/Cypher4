<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Entry extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'cover_image',
        'user_id',
        'stack_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function stack(): BelongsTo
    {
        return $this->belongsTo(Stack::class);
    }

    /**
     * @return HasMany<EntryComponent, $this>
     */
    public function components(): HasMany
    {
        return $this->hasMany(EntryComponent::class);
    }
}
