<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Ladder extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'thumbnail', 'mode',
    ];

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    public function games(): HasMany
    {
        return $this->hasMany(Game::class);
    }

    public function hasSingleMode(): bool
    {
        return $this->mode === 'single';
    }
}
