<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Game extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status', 'processed_at',
    ];

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class)->withPivot('score', 'elo_diff', 'won');
    }

    public function isWinner(Team $team): bool
    {
        return $this->teams->where('id', $team->id)->where('pivot.won', true)->count() === 1;
    }
}
